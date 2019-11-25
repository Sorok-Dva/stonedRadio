<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 12:17
 * @File    : kick.php
 * @Version : 1.0
 */
?>
<div id="right_connexion_title">Le chat de Stoned-Radio</div>
<div id="right_connexion">
    <?php foreach ($kick as $info) :  ?>
     <h1>Vous venez d'être kicker du salon par <?= $info->modo; ?></h1>
    <?php
    endforeach;
    ?>
</div>

