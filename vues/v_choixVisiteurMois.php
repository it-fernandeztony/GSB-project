<?php
/**
 * Vue Choix des visiteurs et du mois pour valider le fiche de frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tony FERNANDEZ <it-fernandeztony@gmail.com>
 */
?>
<div class="row">
    <form method="post" id='form'
          action="index.php?uc=<?php if ($uc == 'gererFrais') { ?>gererFrais&action=saisirFrais<?php 
          } else if ($uc == 'etatFrais') { ?>etatFrais&action=voirEtatFrais<?php } ?>"
          role="form">
        <label for='choixUtilisateur'>Choisir le visiteur: </label>
        <select name='indexListeNom' id='choixUtilisateur' onChange='envoi()'>
            <?php 
                $i = 0;
                foreach($listeNomPrenomVisiteur['nomPrenom'] as 
                    $nom=>$unNomPrenomVisiteur) { 
                    if (($indexListeNom == $i)) {
                    echo '<option value=' . $i . ' selected >' 
                    . $unNomPrenomVisiteur . '</option>';    
                    } else {
                    echo '<option value=' . $i . '>' . $unNomPrenomVisiteur
                    . '</option>';
                    }
                    $i += 1;
                }
            ?>
        </select>
        <label for='choixMois'>Mois: </label>
        <select name='indexListeMois' id='choixMois' onChange='envoi()'>
            <?php
            $j = 0;
            foreach($listeNomPrenomVisiteur['mois'][$indexListeNom] as 
                    $cle=>$value) { 
                if ($indexListeMois == $j) {
                    echo '<option value=' . $j . ' selected >' 
                    . $value . '</option>';
                } else {
                    echo '<option value=' . $j . '>' . $value
                    . '</option>';
                }
                $j += 1;
            }
            ?>
        </select>
    </form>
</div>
<?php 

if (($action == 'validerFicheDeFrais' && nbErreurs()== 0) ||
        $action == 'majEtatRembourse' || $action == 'majEtatMisePaiement') {
?><script> envoi(); </script>
<?php
}
?>