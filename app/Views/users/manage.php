<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 19/07/2015
 * @Time    : 13:58
 * @File    : manage.php
 * @Version : 1.0
 * @Todo    : À completer!
 */
App::getInstance()->subtitle = "Modifier ses informations";

if($uploadAvatarError): ?>
    <script>
        notif({
            msg: "<b>Erreur:</b> Votre avatar ne respecte pas les conditions d'upload. Vérifiez qu'il ne soit pas plus grand que 1MB, qu'il soit au " +
            "format PNG,GIF,JPG ou JPEG.",
            width: 600,
            multiline: 1,
            timeout: 15000,
            type: "error"
        });
    </script>
<?php endif; ?>
    <div id="right_connexion_title">Modifier vos informations</div>
        <div id="right_connexion">
            <div class="col-xs-12">
                <div class="col-sm-4" style="padding:15px">
                    <table class="col-sm-12 ">
                        <tr>
                            <td id="monAvatar" style="padding: 10px 20px;">
                                <form method="post" enctype="multipart/form-data">
                                    <img style="margin-left: 20px;" id="uploadPreview1"  class="avatar-md round-corner media-object inline-block" src="<?= $_SESSION['avatar'] ?>">
                                    <br /><br /><button href="#import-img" type="button" class="btn btn-warning bout-md-width no-corner  btn-create-import-image">Choisssez un avatar<input id="uploadImage1" type="file" name="avatar" onchange="PreviewImage(1);" /></button>
                                    <br><br>
                                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8" style="padding:15px">
                    <div class="col-sm-12">
                        <div id="identite">
                            <label class="label-edit-profil">Pseudo :</label>
                                    <span class="bold"><?= $info->pseudo ?>
                                    </span>
                        </div><hr>
                        <div id="mail">
                            <label class="label-edit-profil">E-mail :</label>
                                    <span class="bold">Cette information est privée.
                                        <button onclick="updateProfile('mail')" class="btn btn-primary pull-right" style="display:inline-block; padding:1px 12px">Modifier</button>
                                    </span>
                        </div><hr>
                        <div id="password">
                            <label class="label-edit-profil">Mot de passe:</label>
                                    <span class="bold">
                                        <button onclick="updateProfile('password')" class="btn btn-primary pull-right" style="display:inline-block; padding:1px 12px">Modifier</button>
                                    </span>
                        </div><hr>
                        <center><h3>Suppression du compte :</h3></center>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>La suppression de votre compte est irréversible, si vous décidez de le supprimer il sera impossible de le récupérer.
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="pass_del">Mot de passe :</label>
                            <div class="col-sm-8">
                                <input type="password" name="pass_del" class="form-control" id="delPassword" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-7">
                                   <input type="submit" name="delete" value="Supprimer mon compte" class="btn btn-danger" onclick="DeleteAccount()"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        function PreviewImage(no) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
            };
        }
    </script>