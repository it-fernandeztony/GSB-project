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
        $listeDeVisiteur = $pdo->getListeVisiteurFicheEtat('CL');
        break;
    case 'etatFrais':
        $listeDeVisiteur = $pdo->getListeVisiteurFicheEtat('VA');
        break;
    default:
        $uc = 'Erreur';
        break;
}
 if (($listeDeVisiteur != null) && ($uc != 'Erreur')) {
    $listeNomPrenomVisiteur['nomPrenom'] = creerListeNomPrenom($listeDeVisiteur);
    $listeNomPrenomVisiteur['idVisiteur'] = extraireListe($listeDeVisiteur,'idVisiteur');
    $indexListeNom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_NUMBER_INT);
    if ($indexListeNom == null) {
        $indexListeMois = 0;
        $indexListeNom = 0;
    } else {
        $indexListeMois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_NUMBER_INT);
    }
    $listeMois = null;
    foreach ($listeNomPrenomVisiteur['idVisiteur'] as $valeur) {
        if ($uc == 'gererFrais') {
            $listeMois[] = formatMois($pdo->getLesMoisEtat($valeur,'CL'));
        } else if ($uc == 'etatFrais') {
            $listeMois[] = formatMois($pdo->getLesMoisEtat($valeur,'VA'));
        }
    }
    $listeNomPrenomVisiteur['mois'] = $listeMois;
} else if (($listeDeVisiteur == null) && ($uc != 'Erreur')){
    ajouterErreur('Il n\'éxiste aucune fiche à valider');
}
