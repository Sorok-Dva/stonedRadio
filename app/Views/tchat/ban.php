<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 12:35
 * @File    : ban.php
 * @Version : 1.0
 * @Todo    : À completer!
 */
?>
<div id="right_connexion_title">Le chat de Stoned-Radio</div>
<div id="right_connexion">
    <?php foreach ($ban as $info) :  ?>
        <h1>Vous êtes banni du tchat par <?= $info->modo; ?></h1>
        <?php
    endforeach;
    ?>
</div>


