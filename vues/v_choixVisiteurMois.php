<?php
/**
 * Vue Choix des visiteurs et du mois pour valider le fiche de frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tony Fernandez <it.fernandeztony@gmail.com>
 */
?>
<div class="row">
    <form method="post" id='form'
          action="index.php?uc=gererFrais&action=saisirFrais" 
          role="form">
        <label for='choixUtilisateur'>Choisir le visiteur: </label>
        <select name='nom' id='choixUtilisateur' onChange='envoi()'>
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
        <select name='mois' id='choixMois' onChange='envoi()'>
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