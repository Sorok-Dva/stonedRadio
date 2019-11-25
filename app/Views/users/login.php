<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 12:33
 * @File    : login.php
 * @Version : 2.0
 */
if($errors):
?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Les identifiants que vous avez saisi sont incorrects.",
            width: 600,
            timeout: 5000,
            type: "error"
        });
    </script>
<?php endif; ?>
<div id="right_connexion_title">Connexion à Stoned-Radio</div>

<div id="right_connexion">

    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Vous pouvez vous connecter afin de pouvoir poster des <strong>dédicaces</strong> ou discuter sur le <strong>tchat</strong>.
    </div>
    <form method="post" autocomplete="off" >
        <?= $form->input('username', 'Pseudo'); ?>
        <?= $form->input('password', 'Mot de Passe', ['type' => 'Password']); ?>
        <?= $form->submit('Se connecter'); ?>
    </form>
</div>