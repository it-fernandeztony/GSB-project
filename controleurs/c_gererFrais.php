<?php
/**
 * Gestion des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Tony FERNANDEZ <it.fernandeztony@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

if ($_SESSION['utilisateur'] == 'visiteur') {
    $idVisiteur = $_SESSION['idVisiteur'];
    $mois = getMois(date('d/m/Y'));
    $numAnnee = substr($mois, 0, 4);
    $numMois = substr($mois, 4, 2);
}else{
    $nbJustificatifs = $pdo->getNbJustificatifs($idVisiteur,$mois);
}
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'saisirFrais':
    if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
    }
    break;
case 'validerMajFraisForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        if ($_SESSION['utilisateur'] == 'comptable') {
            ajouterReussite('Les frais ont été mis à jour.');
            include 'vues/v_succes.php';
        }
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    break;
case 'validerCreationFrais':
    $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    valideInfosFrais($dateFrais, $libelle, $montant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $dateFrais,
            $montant
        );
    }
    break;
case 'majFraisHorsForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $indexId = rechercheBoutonUtilise($lesFrais['id']);
    if (is_array($lesFrais['id'])) {
    $idFrais = $lesFrais['id'][$indexId];
    $dateFrais = $lesFrais['date'][$indexId];
    $libelle = $lesFrais['libelle'][$indexId];
    $montant = $lesFrais['montant'][$indexId];
    } else {
        $idFrais = $lesFrais['id'];
        $dateFrais = $lesFrais['date'];
        $libelle = $lesFrais['libelle'];
        $montant = $lesFrais['montant'];
    }
    valideInfosFrais($dateFrais, $libelle, $montant);
     if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->majFraisHorsForfait(
            $idFrais,
            $dateFrais,
            $libelle,
            $montant
        );
        ajouterReussite('Les frais ont été mis à jour.');
        include 'vues/v_succes.php';
    }
    break;
case 'reporterFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $libelleAModifie = filter_input(INPUT_GET, 'libelle', FILTER_SANITIZE_STRING);
    $libelleChange = verificationLongueurChaine($libelleAModifie, 30);
    $moisSuivant = moisSuivant($mois);
    if ($pdo->estPremierFraisMois($idVisiteur,$moisSuivant)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
    }
    $pdo->reporterFraisHorsForfait($idFrais, $libelleChange, $moisSuivant);
    break;
case 'validerFicheDeFrais':
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs);
        $pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA');
        $indexListeNom = 0;
        $indexListeMois = 0;
    }
    break;
case 'supprimerFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $pdo->supprimerFraisHorsForfait($idFrais);
    break;
default:
    ajouterErreur('Une erreur est survenue. Merci de contacter votre administrateur');
    include 'vues/v_erreurs.php';
    break;
}
if ($uc != 'Erreur') {
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    require 'vues/v_listeFraisForfait.php';
    require 'vues/v_listeFraisHorsForfait.php';
}