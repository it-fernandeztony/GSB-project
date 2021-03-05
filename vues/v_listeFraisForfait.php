<?php
/**
 * Vue Liste des frais au forfait
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
?>
<div class="row">    
    
    <h2 <?php if ($_SESSION['utilisateur']=="comptable") {
        echo "class=comptable"; 
        } 
        ?>>
        <?php if ($_SESSION['utilisateur']== "visiteur") { ?>
        Renseigner ma fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee;
        } else {
        ?>
        Valider la fiche de frais
        <?php
        }
        ?>
    </h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=gererFrais&action=validerMajFraisForfait" 
              role="form">
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">
                    <?php if ($_SESSION['utilisateur'] == 'visiteur') { ?>
                        Ajouter
                    <?php } else if ($_SESSION['utilisateur'] == 'comptable') { ?>
                        Corriger
                    <?php } ?>
                </button>
                    <?php if ($_SESSION['utilisateur'] == 'visiteur') { ?>
                        <button class="btn btn-danger" type="reset">    
                        Effacer
                    <?php } else if ($_SESSION['utilisateur'] == 'comptable') { ?>
                        <button class="btn btn-danger" onclick='envoi()' type="button">
                        Réinitialiser
                    <?php } ?> 
                </button>
            </fieldset>
        </form>
    </div>
</div>
