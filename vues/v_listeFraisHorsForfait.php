<?php
/**
 * Vue Liste des frais hors forfait
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<hr>
<div class="row">
    <div class="panel panel-info tableau-<?php 
    echo $_SESSION['utilisateur']?>">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <form action="index.php?uc=gererFrais&action=majFraisHorsForfait" 
                method="post" role="form">
            <?php if ($_SESSION['utilisateur'] == 'comptable') { ?>
                <input type="hidden" name="indexListeNom" value="<?php echo $indexListeNom ?>">
                <input type="hidden" name="indexListeMois" value="<?php echo $indexListeMois ?>">
            <?php
            }
            ?>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>  
                        <th class="montant">Montant</th>  
                        <th class="action">&nbsp;</th> 
                    </tr>
                </thead>  
                <tbody>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id']; 
                    if ($_SESSION['utilisateur'] == 'comptable') {
                    ?>
                    <tbody>
                        <tr>
                            <input type="hidden" name="lesFrais[id]" 
                                   value="<?php echo $id; ?>">
                        <td> 
                            <input type="text" name="lesFrais[date]" size="5" 
                                   class="form-control" maxlength="10"
                                   value="<?php echo $date; ?>"></td>
                        <td> 
                            <input type="text" name="lesFrais[libelle]" size="20" 
                                   class="form-control" maxlength="30"
                                   value="<?php echo $libelle; ?>"></td>
                        <td> 
                            <input type="text" name="lesFrais[montant]" size="5" 
                                   class="form-control" maxlength="6"
                                   value="<?php echo $montant; ?>"></td>
                        <td>
                            <button class="btn btn-success" type="submit" name="<?php echo $id
                                    ?>">Corriger</button>
                            <button class="btn btn-danger" onclick="envoi()" type="button">Réinitialiser</button>
                            <a href="index.php?uc=gererFrais&action=reporterFrais&idFrais=<?php echo $id; 
                            ?>&libelle=REFUSER : <?php echo $libelle;?>&indexListeNom=<?php echo $indexListeNom; 
                            ?>&indexListeMois=<?php echo $indexListeMois;
                            ?>" 
                            onclick="return confirm('Voulez-vous vraiment reporter ce frais?');">Reporter ce frais</a></td>
                        </tr>
                        <?php
                    } else {
                    ?> 
                        <tr>
                        <td> <?php echo $date ?></td>
                        <td> <?php echo $libelle ?></td>
                        <td> <?php echo $montant ?></td>
                        <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id;
                        ?>" 
                            onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>  
            </table>
        </form>
    </div>
</div>
<?php 
if ($_SESSION['utilisateur'] == 'visiteur') { ?>
    <div class="row">
        <h3>Nouvel élément hors forfait</h3>
        <div class="col-md-4">
            <form action="index.php?uc=gererFrais&action=validerCreationFrais" 
                method="post" role="form">
                <div class="form-group">
                    <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                    <input type="text" id="txtDateHF" name="dateFrais" 
                        class="form-control" id="text">
                </div>
                <div class="form-group">
                    <label for="txtLibelleHF">Libellé</label>             
                    <input type="text" id="txtLibelleHF" name="libelle" 
                        class="form-control" id="text">
                </div> 
                <div class="form-group">
                    <label for="txtMontantHF">Montant : </label>
                    <div class="input-group">
                        <span class="input-group-addon">€</span>
                        <input type="text" id="txtMontantHF" name="montant" 
                            class="form-control" value="">
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Ajouter</button>
                <button class="btn btn-danger" type="reset">Effacer</button>
            </form>
        </div>
    </div>
<?php 
} else { 
?>
    <div class="row">
        <form method="post" 
             action="index.php?uc=gererFrais&action=validerFicheDeFrais" 
             role="form">
            <input type="hidden" name="indexListeNom" value="<?php echo $indexListeNom ?>">
            <input type="hidden" name="indexListeMois" value="<?php echo $indexListeMois ?>">
            <label for="nbJustificatif">Nombre de justificatifs :</label>
            <input type="text" id="nbJustificatifs" 
                               name="nbJustificatifs"
                               size="1" maxlength="2" 
                               value="<?php echo $nbJustificatifs ?>" 
                               class="form-group">
            <button class="btn btn-success" type="submit">Valider la fiche</button>
            <button class="btn btn-danger" onclick="envoi()" type="button">Réinitialiser</button>
         </form>
    </div>
<?php         
}
?>