<?php

/**
 * Sélection des visiteurs et des mois pour la validation de fiche de frais.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tony Fernandez <it.fernandeztony@gmail.com>
 * @version   GIT: <0>
 */

$listeDeVisiteur = $pdo->getNomPrenomVisiteurs();
if ($listeDeVisiteur != null) {
    $listeNomPrenomVisiteur['nomPrenom'] = creerListeNomPrenom($listeDeVisiteur);
    $listeNomPrenomVisiteur['idVisiteur'] = extraireListe($listeDeVisiteur,'idVisiteur');
    $indexListeNom = intval(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING));
    if ($indexListeNom == null) {
        $indexListeMois = 0;
        $indexListeNom = 0;
    } else {
        $indexListeNom = intval(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING));
        $indexListeMois = intval(filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING));
    }
    $listeMois = null;
    foreach ($listeNomPrenomVisiteur['idVisiteur'] as $valeur) {
        $listeMois[] = formatMois($pdo->getLesMoisCloture($valeur));
    }
    $listeNomPrenomVisiteur['mois'] = $listeMois;
    require 'vues/v_choixVisiteurMois.php';
} else {
    ajouterErreur('Il n\'éxiste aucune fiche à valider');
}