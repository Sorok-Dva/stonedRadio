<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 18:27
 * @File    : recoveryPassword.php
 * @Version : 1.0
 */
?>
    <div id="right_mdp_title">Mot de passe oublié <strong>(&Eacute;tape 1/2)</strong></div>
    <div id="right_mdp">
        <p>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Si tu désires obtenir un nouveau mot de passe, rentre ton pseudo et ton e-mail ci-dessous afin de recevoir un mail qui te permettra de changer de mot de passe.
        </div>
<?php
    if(!empty($info)):
        echo $info;
    endif;
?>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label class="control-label col-sm-3" for="pseudo">Pseudo :</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="mail">E-mail :</label>
                <div class="col-sm-8">
                    <input class="form-control" type="email" name="mail" id="mail" placeholder="Votre email" required>
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


