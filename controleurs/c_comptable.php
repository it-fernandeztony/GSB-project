<?php

/**
 * Sélection des visiteurs et des mois pour la validation de fiche de frais.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tony FERNANDEZ <it-fernandeztony@gmail.com>
 * @version   GIT: <0>
 */

switch ($uc) {
    case 'gererFrais':
        $listeDeVisiteur = $pdo->getListeVisiteurFicheEtat('CL', null);
        break;
    case 'etatFrais':
        $listeDeVisiteur = $pdo->getListeVisiteurFicheEtat('VA', 'PM');
        break;
    default:
        $uc = 'Erreur';
        break;
}
 if (($listeDeVisiteur != null) && ($uc != 'Erreur')) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
     $listeNomPrenomVisiteur['nomPrenom'] = creerListeNomPrenom($listeDeVisiteur);
    $listeNomPrenomVisiteur['idVisiteur'] = extraireListe($listeDeVisiteur,'idVisiteur');
    $indexNom = filter_input(INPUT_POST, 'indexListeNom', FILTER_SANITIZE_NUMBER_INT);
    if ($indexNom == null) {
        $indexMois = 0;
        $indexNom = 0;
    } else {
        $indexMois = filter_input(INPUT_POST, 'indexListeMois', FILTER_SANITIZE_NUMBER_INT);
    }
    $listeMois = $pdo->rechercheListeMois($listeNomPrenomVisiteur['idVisiteur'], $uc);
    $listeNomPrenomVisiteur['mois'] = $listeMois;
    $indexListeNom = verificationIndex($listeNomPrenomVisiteur['idVisiteur'], $indexNom);
    $idVisiteur = $listeNomPrenomVisiteur['idVisiteur'][$indexListeNom];
    $indexListeMois = verificationIndex($listeNomPrenomVisiteur['mois'][$indexListeNom], $indexMois);
    $moisOrdonne = $listeNomPrenomVisiteur['mois'][$indexListeNom][$indexListeMois];
    $numAnnee = substr($moisOrdonne, 5);
    $numMois = substr($moisOrdonne, 0, 2);
    $mois = $numAnnee . $numMois;
    if (($_SESSION['utilisateur'] == 'comptable') 
        && $listeDeVisiteur != null ) {
        require 'vues/v_choixVisiteurMois.php';
    }
} else if (($listeDeVisiteur == null) && ($uc != 'Erreur')){
    ajouterErreur('Il n\'éxiste aucune fiche nécessitant une intervention.');
    include 'vues/v_erreurs.php';
}
