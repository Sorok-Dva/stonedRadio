<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 12:13
 * @File    : animatorArea.php
 * @Version : 1.0
 */
?>
<div id="right_anim_title">Espace animateur</div>
<div id="right_anim">
    <h3><center>Bienvenue <b><?= $_SESSION['pseudo']; ?></b> sur ton espace animateur !</center></h3><br />
    Ici, tu pourras consulter les dédicaces postées afin de les lires à l'antenne ou bien encore gérer le lancement/fin de ton émission !
</div>
<div id="right_anim_title">Gestion de ton émission</div>
<div id="right_anim">
    <center><strong>Émission en cours</strong> :
        <?php include 'player/sale.php'; ?>
    </center><br />
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Quand tu commences ton émission ou tu que tu la termines, n'oublie <strong>SURTOUT</strong> pas de changer
        le statut de l'émission.
    </div>
    <?php
	mysql_connect('mysql5-15.60gp', 'boido', 'pommeret06');
	mysql_select_db('boido');
	$selectemission = mysql_query('SELECT direct FROM direct_v3');
	$dataemission = mysql_fetch_array($selectemission);
    if($_SESSION['pseudo']=="Anthony" or $_SESSION['pseudo']=="Nico")
    {
        ?>
        Tu présentes la libre antenne Le Stoned tous les dimanches de 16h à 18h.<br /><br />
        <b>Statut de l'émission</b> :
        <?php
        if($_POST['f_stoned'])
        {
            mysql_query('UPDATE direct_v3 SET direct=0');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($_POST['d_stoned'])
        {
            mysql_query('UPDATE direct_v3 SET direct=1');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($dataemission['direct']==1)
        {
            echo "En cours";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="f_stoned" value="Terminer l\'émission" class="btn btn-danger" /></form>';
        }
        else
        {
            echo "Pas encore lancé";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="d_stoned" value="Lancer l\'émission" class="btn btn-success" /></form>';
        }
    }

    if($_SESSION['pseudo']=="Anthony" or $_SESSION['pseudo']=="Tatane")
    {
        ?>
        <br />
        Tu présentes The Stoned Song tous les vendredis de 21h à 22 et les dimanches de 15h à 16h.<br /><br />
        <b>Statut de l'émission</b> :
        <?php
        if($_POST['f_song'])
        {
            mysql_query('UPDATE direct_v3 SET direct=0');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($_POST['d_song'])
        {
            mysql_query('UPDATE direct_v3 SET direct=2');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($dataemission['direct']==2)
        {
            echo "En cours";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="f_song" value="Terminer l\'émission" class="btn btn-danger" /></form>';
        }
        else
        {
            echo "Pas encore lancé";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="d_song" value="Lancer l\'émission" class="btn btn-success" /></form>';
        }
    }

    if($_SESSION['pseudo']=="Anthony"  or $_SESSION['pseudo']=="Kinder")
    {
        ?>
        <br />
        Tu présentes Musicalement Historique tous les mardis et mercredis de 21h à 22h.<br /><br />
        <b>Statut de l'émission</b> :
        <?php
        if($_POST['f_star'])
        {
            mysql_query('UPDATE direct_v3 SET direct=0');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($_POST['d_star'])
        {
            mysql_query('UPDATE direct_v3 SET direct=3');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($dataemission['direct']==3)
        {
            echo "En cours";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="f_star" value="Terminer l\'émission" class="btn btn-danger" /></form>';
        }
        else
        {
            echo "Pas encore lancé";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="d_star" value="Lancer l\'émission" class="btn btn-success" /></form>';
        }
    }

    if($_SESSION['pseudo']=="Greg" or $_SESSION['pseudo']=="Anthony")
    {
        ?>
        <br />
        Tu présentes Open Space tous les lundis et mardis de 18h à 21h, mercredis et jeudis de 20h à 21h et le vendredi de 18h à 19h.<br /><br />
        <b>Statut de l'émission</b> :
        <?php
        if($_POST['f_space'])
        {
            mysql_query('UPDATE direct_v3 SET direct=0');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($_POST['d_space'])
        {
            mysql_query('UPDATE direct_v3 SET direct=4');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($dataemission['direct']==4)
        {
            echo "En cours";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="f_space" value="Terminer l\'émission" class="btn btn-danger" /></form>';
        }
        else
        {
            echo "Pas encore lancé";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="d_space" value="Lancer l\'émission" class="btn btn-success" /></form>';
        }
    }

    if($_SESSION['pseudo']=="Tatane" or $_SESSION['pseudo']=="Anthony")
    {
        ?>
        <br />
        Tu présentes Stoned Rediffusion tous les lundis de 21h à 23h<br /><br />
        <b>Statut de l'émission</b> :
        <?php
        if($_POST['f_r'])
        {
            mysql_query('UPDATE direct_v3 SET direct=0');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($_POST['d_r'])
        {
            mysql_query('UPDATE direct_v3 SET direct=5');
            echo '<script>document.location.href="?page=users.animatorArea";</script>';
        }
        if($dataemission['direct']==5)
        {
            echo "En cours";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="f_r" value="Terminer l\'émission" class="btn btn-danger" /></form>';
        }
        else
        {
            echo "Pas encore lancé";
            echo " &nbsp; ";
            echo '<form method="post"><input type="submit" name="d_r" value="Lancer l\'émission" class="btn btn-success" /></form>';
        }
    }
    ?>
</div>

<div id="right_anim_title">Lire les dédicaces</div>
<div id="right_anim">
    ça arrive
</div>
