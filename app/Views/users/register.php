<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 19:06
 * @File    : register.php
 * @Version : 1.0
 * @Todo    : À completer!
 */
App::getInstance()->subtitle = "Inscription";

if($errorDuplicateMail): ?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Cette adresse e-mail est déjà utilisée",
            timeout: 5000,
            type: "error"
        });
    </script>
<?php endif;

if($errorDuplicatePseudo): ?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Ce pseudo est déjà utilisé",
            timeout: 5000,
            type: "error"
        });
    </script>
<?php endif;

if($missingFields): ?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Vous n'avez pas rempli tout les champs",
            timeout: 5000,
            type: "error"
        });
    </script>
<?php endif;

if($passDoesntMatch): ?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Les deux mots de passes sont différents",
            timeout: 5000,
            type: "error"
        });
    </script>
<?php endif; ?>
<div id="right_inscription_title">Inscription à Stoned-Radio</div><br><br>
    <div id="right_wrapper">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Vous pouvez vous inscrire afin de pouvoir poster des <strong>dédicaces</strong> ou discuter sur le <strong>tchat</strong>.
        </div>
        <div class="col-lg-12">
            <form method="post" autocomplete="off">
                <?= $form->input('pseudo', 'Pseudo', ['placeholder' => 'Votre pseudo', 'class' => 'verifPseudo',  'onkeypress' => 'registrationVerify("pseudo")',  'onkeyup' => 'registrationVerify("pseudo")']); ?>
                <?= $form->input('mail', 'E-mail', ['placeholder' => 'Votre adresse email (valide)', 'class' => 'verifMail',  'onkeypress' => 'registrationVerify("mail")',  'onkeyup' => 'registrationVerify("mail")']); ?>
                <?= $form->input('password', 'Mot de Passe', ['placeholder' => 'Votre mot de passe', 'type' => 'password', 'class' => 'verifPass',  'onkeypress' => 'registrationVerify("pass")',  'onkeyup' => 'registrationVerify("pass")']); ?>
                <?= $form->input('retypePassword', 'Confirmation', ['placeholder' => 'Confirmer votre mot de passe', 'type' => 'password', 'class' => 'verifRetypePassword',  'onkeypress' => 'registrationVerify("retypePassword")',  'onkeyup' => 'registrationVerify("retypePassword")']); ?>
                <label>Votre sexe</label>
                <select class="form-control" id="sexe" name="sexe">
                    <option selected="" value="na">Vous êtes?</option>
                    <option value="H">Un Homme</option>
                    <option value="F">Une Femme</option>
                </select><br>
                <?= $form->submit('Valider'); ?>
            </form>
        </div>
    </div>
</div>



