<?php
/**
 * Vue Réussites
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tony FERNANDEZ <it.fernandeztony@gmail.com>
 * @version   GIT: <0>
 */
?>
<div class="alert alert-success" role="success">
    <?php
    foreach ($_REQUEST['reussites'] as $reussite) {
        echo '<p>' . htmlspecialchars($reussite) . '</p>';
    }
    ?>
</div>