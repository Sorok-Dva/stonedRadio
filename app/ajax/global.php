<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 10:56
 * @File    : global.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

try {
    $dbname = 'boido';
    $user = 'boido';
    $server = 'mysql5-15.60gp';
    $pass = 'pommeret06';
    $bdd = new PDO ('mysql:host=' . $server . ';dbname=' .$dbname, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}
catch (PDOException $e) {
    die();
}

/**
 * On vérifie que l'utilisateur n'est pas kick
 */
    $isPresent = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "'.$_SESSION['pseudo'].'"');
    $present = $isPresent->rowCount();

    $isBan = $bdd->query('SELECT * FROM tchat_bans WHERE user = "'.$_SESSION['pseudo'].'"');
    $banni = $isBan->rowCount();

    if($present == 0) {
        if ($banni == 1) {
            $return['redir'] = "ban";
        }
        $return['erreur'] = "fatal";
        $return['redir'] = "kick";
    } else {
        $return['erreur'] = "";
    }

/**
 * On récupère les liste des utilisateurs présents
 */
    $verifUser = $bdd->query('SELECT * FROM tchat_users');
    $fetch = $verifUser->fetchAll();

    $return['droite'] = "";

    foreach($fetch as $user):

        if ($user['mute'] == "Y") {
            $mute = " <i>(Baîlloner)</i>";
        } else {
            $mute = "";
        }

        $return['droite'] .= "<div class=\"".$user['status']."\"></div> &nbsp; <span class=\"user\">".$user['pseudo']."</span>".$mute."<br>";

    endforeach;

    /**
     *  On switch le status des utilisateurs AFK depuis 10 minutes et kick ceux afk depuis 60
     */

    foreach($fetch as $user):

        $afk = $user['last_msg']+1800;
        $kick = $user['last_msg']+3600;

        if ($user['pseudo'] != "Lisa"){
            if (time() > $afk){
                $exec = $bdd->exec('UPDATE tchat_users SET status="AFK" WHERE pseudo = "' . $user['pseudo'] . '"');
            }
            if (time() > $kick){
                $exec = $bdd->exec('DELETE FROM tchat_users WHERE pseudo = "' . $user['pseudo'] . '"');
                $return['redir'] = "logout";
            }

        }


endforeach;


echo json_encode($return);