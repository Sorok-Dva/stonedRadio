<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 19:40
 * @File    : oldDedi.php
 * @Version : 1.0
 */

	extract($_POST);
	session_start();
	header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	$error_ban = false;
	mysql_connect('mysql5-15.60gp', 'boido', 'pommeret06');
	mysql_select_db('boido');
	$req_ban_users = mysql_query('SELECT * FROM ban_v2 WHERE actif="0" && ip="'.$_SERVER["REMOTE_ADDR"].'" && duree > "'.time().'"');
	if(mysql_num_rows($req_ban_users)==1)
    {
        $error_ban = true;
        $data_ban_users = mysql_fetch_array($req_ban_users);
        echo '<script>$("#formcom").trigger("reset");</script>';
        echo "<div class=\"alert-box error\"><span>Erreur : </span>Vous ne pouvez pas poster de dédicace car votre IP est banni pour le motif suivant : <strong>".$data_ban_users['motif']."</strong>.</div>";
    }
    else
    {
        $req_ban_users5 = mysql_query('SELECT * FROM ban_v2 WHERE actif="0" && compte_banni="'.$_SESSION['pseudo'].'" && duree > "'.time().'"');
        if(mysql_num_rows($req_ban_users5)==1)
        {
            $error_ban = true;
            $data_ban_users5 = mysql_fetch_array($req_ban_users5);
            echo '<script>$("#formcom").trigger("reset");</script>';
            echo "<div class=\"alert-box error\"><span>Erreur : </span>Vous ne pouvez pas poster de dédicace car votre compte est banni pour le motif suivant : <strong>".$data_ban_users5['motif']."</strong>.</div>";
        }
        else
        {
            if(isset($_SESSION['pseudo']) && isset($com) && !empty($com))
            {
                $time = time();
                mysql_query('INSERT INTO dedi_v2 VALUES("", "'.$_SESSION['pseudo'].'", "'.utf8_decode(mysql_real_escape_string($com)).'", "'.time().'", "0", "ok")') or die(mysql_error());
                echo "ok";
            }
            else
            {
                echo "<div class=\"alert-box error\"><span>Erreur : </span>Veuillez remplir le champ dédi ou connectez-vous  !</div>";
            }
        }
    }

?>