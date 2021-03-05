<?php
/**
 * Vue État de Frais
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
<hr>
<div class="panel panel-primary <?php echo $_SESSION['utilisateur']; ?>">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info tableau-<?php 
    echo$_SESSION['utilisateur']?>">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info tableau-<?php 
    echo $_SESSION['utilisateur']?>">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php switch ($idEtat) {
    case 'VA':?>
        <form action="index.php?uc=etatFrais&action=majEtatMisePaiement"
              method="post" role="form">
            <input type="hidden" name="indexListeNom" value="<?php echo $indexListeNom ?>">
            <input type="hidden" name="indexListeMois" value="<?php echo $indexListeMois ?>">
            <button class="btn btn-success" type="submit">Fiche Mise en paiement</button>
        </form>
    <?php break;
    case 'PM': ?>
        <form action="index.php?uc=etatFrais&action=majEtatRembourse"
              method="post" role="form">
            <input type="hidden" name="indexListeNom" value="<?php echo $indexListeNom ?>">
            <input type="hidden" name="indexListeMois" value="<?php echo $indexListeMois ?>">
            <button class="btn btn-success" type="submit">Fiche remboursée</button>
        </form>
    <?php break;
    default:
    break;
}
?>