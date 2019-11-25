<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 12/08/2015
 * @Time    : 17:32
 * @File    : getChat.php
 * @Version : 1.0
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

if ($_POST['action'] == "getChat"):
    if(!empty($_GET) AND ($_GET['first']== "1")) {
        $return['content'] = "";
        $getChat = $bdd->query('SELECT * FROM tchat ORDER BY id');
        $resultat = $getChat->fetchAll();


        foreach($resultat as $post ){

            $getSexe = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$post['user'].'"');
            $sexe = $getSexe->fetch();
            switch($sexe['sexe']){
                case 'H': $sexe = "♂"; break;
                case 'F': $sexe = "♀"; break;
                default: $sexe ="";break;
            }
            if ($post['type'] == "J"){
                $return['content'] .= "<br><b>".$sexe."</b> <span class='canal_joueurs'><b>".$post['user']."</b> <i style='font-size:80%'>(".strftime("%H:%M:%S", $post['date']).")</i> : ".$post['message']."</span>";
            }
            if ($post['type'] == "I"){
                $return['content'] .= "<br><span class='canal_info'>".$post['message']."</span>";
            }
            if ($post['type'] == "M") {
                $return['content'] .= "<br><span class='canal_info'><b style=\"color:red\">(Modérateur) " . $post['message'] . "</b></span>";
            }
            if ( ($post['type'] == "P") AND ($post['prive'] == $_SESSION['pseudo'])){
                $return['content'] .= "<br> <span class='canal_perso'><i>(Modération)</i> <b>Privé</b> <i style='font-size:80%'>(".strftime("%H:%M:%S", $post['date']).")</i> : ".$post['message']."</span>";
            }

            $return['lastM'] = $post['id'];
        }

        echo json_encode($return);
    } else {
        $lastM = $_POST['lastM'];
        $current = $lastM + 1;
        $getChat = $bdd->query('SELECT * FROM tchat WHERE id = "' . $current . '" ORDER BY id');
        $resultat = $getChat->fetch();
        $count = $getChat->rowCount();
        $newMessage = $count;

        set_time_limit(0);
        do {
            if ($count != 0) {
                $getSexe = $bdd->query('SELECT * FROM users WHERE pseudo = "'.$resultat['user'].'"');
                $sexe = $getSexe->fetch();
                switch($sexe['sexe']){
                    case 'H': $sexe = "♂"; break;
                    case 'F': $sexe = "♀"; break;
                    default: $sexe ="";break;
                }

                if ($resultat['type'] == "J"){
                    $message = "<br><b>".$sexe."</b> <span class='canal_joueurs'><b>".$resultat['user']."</b> <i style='font-size:80%'>(".strftime("%H:%M:%S", $resultat['date']).")</i> : ".$resultat['message']."</span>";
                }
                if ($resultat['type'] == "I"){
                    $message = "<br><span class='canal_info'>".$resultat['message']."</span>";
                }
                if ($resultat['type'] == "M"){
                    $message = "<br><b style=\"color:red\"><i>(Modération)</i></b> <b style=\"color:red\">" . $resultat['message'] . "</b>";

                }
                if (($resultat['type'] == "P") AND($resultat['prive'] == $_SESSION['pseudo'])){
                    $message = "<br> <span class='canal_perso'><i>(Modération)</i> <b>Privé</b> <i style='font-size:80%'>(".strftime("%H:%M:%S", $resultat['date']).")</i> : ".$resultat['message']."</span>";
                }
                if ($resultat['reset'] == "Y"){
                    $truncate = $bdd->exec('TRUNCATE tchat');
                    $exec= $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "Annonce", "<b>Le tchat viens d\'être réinitialiser par '.$_SESSION['pseudo'].'. </b>", "'.time().'", "M")');
                    $return = array(
                        "content" => $message,
                        "clear" => "Y",
                        "lastM" => "1"
                    );
                    echo json_encode($return);
                } else {
                    $return = array(
                        "content" => $message,
                        "lastM" => $resultat['id']
                    );
                    echo json_encode($return);
                }

            } else {
                usleep(1000);
            }
        } while($newMessage = 0);

    }

endif;

//Je sais pas trop dans ton code mais en pseudocode ca resemble à ceci
/*
 * set_timeout(0)
 *
 * do {
 *   je cherche si j'ai un nouveaux message ou des nouveaux message
 *   si oui
 *     $newMessage = coutn($messsages);
 *     echo mes messages;
 *   si non
 *     msleeep(500); // je wait 500ms avant de refaire un check
 * } while($newMessage = 0)
 *
 *
 * */
