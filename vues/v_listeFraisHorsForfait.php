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
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
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
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <td> <?php echo $date ?></td>
                    <td> <?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                    <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>
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
        </form>
    </div>
</div>