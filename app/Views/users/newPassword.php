<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 18:48
 * @File    : newPassword.php
 * @Version : 1.0
 */

?>
<div id="right_mdp_title">Changer de mot de passe <strong>(&Eacute;tape 2/2)</strong></div>
<div id="right_mdp">
    <p>
        <?php if(!empty($info)){
            echo $info;
        } ?>
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="control-label col-sm-3" for="mdp">Nouveau mot de passe :</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="mdp" id="mdp" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="mdp2">Retapez le mot de passe :</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="mdp2" id="mdp2" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-7">
                <input type="submit" name="ok" value="Valider" class="btn btn-primary" />
            </div>
        </div>
    </form>
    </p>
</div>
