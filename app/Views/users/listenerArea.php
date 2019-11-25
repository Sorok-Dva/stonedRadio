<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 11:32
 * @File    : listenerArea.php
 * @Version : 1.0
 */
?>
<div id="right_auditeur_title">Espace auditeur</div>
<div id="right_auditeur">
    <h3><center>Bienvenue <b><span class="user"><?= $_SESSION['pseudo']; ?></span></b> sur ton espace auditeur !</center></h3><br />
    Ici, tu pourras consulter tes informations ou bien proposer des musiques pour l'émission "Hits Auditeurs"
    diffusée tous les samedi de 18h à 19h. Pour ce faire, il suffit de remplir le formulaire situé ci-dessous
    en précisant l'artiste et le titre de la musique de ton choix !
    <br /><br />
    <div id="test" class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        En cas d'abus, il se peut que votre compte soit banni définitivement sans avertissement.
    </div>

    <form class="form-horizontal" id="form" method="post">
        <div class="form-group">
            <label class="control-label col-sm-3" for="artiste">Artiste :</label>
            <div class="col-sm-8">
                <input type="text" name="artiste" class="form-control" id="artiste" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="titre">Titre :</label>
            <div class="col-sm-8">
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-7">
                <input type="submit" name="ok" value="Valider" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>
<div id="right_auditeur_title">Mes infos</div>
<div id="right_auditeur">
    <center><h3>Historique de tes musiques proposées</h3></center>
<?php if($erreur != false) {
    echo $erreur;
} else { ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th align="center" width="40%"><center>Artiste</center></th>
                <th width="40%"><center>Titre</center></th>
                <th width="20%"><center>Action</center></th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($askedHits as $hit): ?>
            <tr>
                <th style="padding-top:15px;" width="40%"><center><?= $hit->artiste ?></center></th>
                <th style="padding-top:15px;" width="40%"><center><?= $hit->titre ?></center></th>
                <th width="20%"><center><form method="post"><input type="hidden" name="idToDelete" value="<?= $hit->id ?>" /><input type="submit" name="delete" value="Retirer" class="btn btn-danger" /></form></center></th>
            </tr>

    <?php
        endforeach; ?>
        </tbody>
    </table>
<?php } ?>
</div>
