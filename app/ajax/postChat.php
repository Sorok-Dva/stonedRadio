<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 12/08/2015
 * @Time    : 21:14
 * @File    : postChat.php
 * @Version : 1.0
 * @Todo    : Faire les commandes : kick, ban,
 */

session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

require ('../Functions.php');
function smiley($message) {
    function make($smiley){
        return "<span class='smile ". $smiley ."'></span>";
    }
    $smileys = array(
        ':)'        =>   make(    'happy'     ),
        ':\')'      =>   make(    'MDR'      ),
        ';)'        =>   make(    'wink'       ),
        '^^'        =>   make(    'enjoy'      ),
        '*_*'       =>   make(    'inlove'    ),
        '^^)'       =>   make(    'enjoy'     ),
        '"|'        =>   make(    'envious'   ),
        '>('        =>   make(    'angry'     ),
        '>O'        =>   make(    'angry2'    ),
        ':('        =>   make(    'sad'    ),
        ':\'('      =>   make(    'cry'    ),
        ':))'       =>   make(    'rests'     ),
        ':D'        =>   make(    'laugh'     )

    );
    return strtr($message, $smileys);
}

function filter($message){

    $badWords = array(
        'putain',
        'put1',
        'merde',
        'merd',
        'fdp',
        'pute',
        'connard',
        'con',
    );
    $nbBadWords = count($badWords);

    $replaceBadWords = array(
        'p****',
        'm****',
        'm****',
        'm****',
        '***',
        '***',
        '***',
        'c**',
    );

    for ($i = 0; $i < $nbBadWords; $i++):
        $message = preg_replace("#([^ ]+)$badWords[$i]#i", $replaceBadWords[$i], $message);
    endfor;

    return $message;
}
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

if (!empty($_POST['msg'])) {
    $id = $_SESSION['id'];
    $message = strip_tags(addslashes($_POST['msg']));
    $verifFlood = $bdd->query('SELECT * FROM tchat WHERE user = "'.$_SESSION['pseudo'].'" ORDER BY date DESC LIMIT 0,1');
    $flood = $verifFlood->fetch();
    $verifMute = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "'.$_SESSION['pseudo'].'" AND mute="Y"');
    $ifmute = $verifMute->rowCount();
    $var = $flood['message'];

    $exec= $bdd->exec('UPDATE tchat_users SET last_msg="'.time().'" WHERE pseudo = "'.$_SESSION['pseudo'].'"');

    if ($var == $message) {
        echo "FLOOD";
    }
    else {
        $annonce = explode(' ', $message, 2);
        $prive = explode(' ', $message, 3);
        $mute = explode(' ', $message, 2);
        $kick = explode(' ', $message, 2);
        $dedi = explode(' ', $message, 2);
        if (($annonce[0] == "/modo") OR ($message == "/cls") OR ($prive[0] == "/prive") OR ($mute[0] == "/mute") OR ($mute[0] == "/unmute") OR ($mute[0] == "/kick") OR ($mute[0] == "/ban") OR ($mute[0] == "/unban")) {
            if (($_SESSION['grade'] == "Adm") OR ($_SESSION['grade'] == "Mod") OR ($_SESSION['grade'] == "Dev"))  {
                if ($message == "/cls") {
                    $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type, reset) value( "Annonce", "<b>Le tchat viens d\'être réinitialiser par ' . $_SESSION['pseudo'] . '. </b>", "' . time() . '", "M", "Y")');
                    echo "OK";
                } elseif ($annonce[0] == "/modo") {
                    $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "' . $annonce[1] . '", "' . time() . '", "M")');
                    echo "OK";
                } elseif ($prive[0] == "/prive") {
                    $exec = $bdd->exec('INSERT INTO tchat(user, message, date, prive, type) value( "' . $_SESSION['pseudo'] . '", "' . $prive[2] . '", "' . time() . '", "' . $prive[1] . '", "P")');
                    echo "PRIVE";
                } elseif ($mute[0] == "/mute") {
                    $verifUser = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "' . $mute[1] . '" AND mute="N"');
                    $user = $verifUser->rowCount();

                    if ($user == 1) {
                        $exec = $bdd->exec('UPDATE tchat_users SET mute="Y" WHERE pseudo = "' . $mute[1] . '"');
                        $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "<b>' . $mute[1] . '</b> a été bâillonné par le modérateur <b>' . $_SESSION['pseudo'] . '</b>", "' . time() . '", "I")');
                    }
                    echo "OK";
                } elseif ($mute[0] == "/unmute") {
                    $verifUser = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "' . $mute[1] . '" AND mute="Y"');
                    $user = $verifUser->rowCount();

                    if ($user == 1) {
                        $exec = $bdd->exec('UPDATE tchat_users SET mute="N" WHERE pseudo = "' . $mute[1] . '"');
                        $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "<b>' . $mute[1] . '</b> a été rétabli par <b>' . $_SESSION['pseudo'] . '</b>", "' . time() . '", "I")');
                    }
                    echo "OK";
                } elseif ($kick[0] == "/kick") {
                    $verifUser = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "' . $kick[1] . '"');
                    $user = $verifUser->rowCount();

                    if ($user == 1) {
                        $exec = $bdd->exec('DELETE FROM tchat_users WHERE pseudo = "' . $kick[1] . '"');
                        $exec = $bdd->exec('INSERT INTO tchat_kicks(pseudo, modo, date) value( "' . $kick[1] . '", "' . $_SESSION['pseudo'] . '", "' . time() . '")');
                        $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "<b>' . $kick[1] . '</b> a été exclu du salon par le modérateur <b>' . $_SESSION['pseudo'] . '</b>", "' . time() . '", "I")');
                    }
                    echo "OK";
                } elseif ($kick[0] == "/ban") {
                    $verifUser = $bdd->query('SELECT * FROM tchat_users WHERE pseudo = "' . $kick[1] . '"');
                    $user = $verifUser->rowCount();

                    if ($user == 1) {
                        $exec = $bdd->exec('DELETE FROM tchat_users WHERE pseudo = "' . $kick[1] . '"');
                        $exec = $bdd->exec('INSERT INTO tchat_bans(user, modo, duree, date) value( "' . $kick[1] . '", "' . $_SESSION['pseudo'] . '", "' . time() . '", "' . time() . '")');
                        $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "<b>' . $kick[1] . '</b> a été exclu et banni du salon par le modérateur <b>' . $_SESSION['pseudo'] . '</b>", "' . time() . '", "I")');
                    }
                    echo "OK";
                }
            } else {
                echo "NOT_PERMITTED";
            }
        } elseif($dedi[0] == "/dedi"){
            if ($ifmute == 1) {
                echo "FORBIDDDEN";
            } else {
                $exec = $bdd->exec('INSERT INTO dedi_v2(pseudo, dedi, date) value( "' . $_SESSION['pseudo'] . '", "' . filter(smiley($dedi[1])) . '", "' . time() . '")');
                updateActualDedi();
                echo "DEDI_OK";
            }
        } else {
            if (($message == "/free") OR ($message == "/afk") OR ($message == "/busy")) {
                switch ($message):
                    case "/free":
                        $status = "Online";
                        break;
                    case "/busy":
                        $status = "Busy";
                        break;
                    case "/afk":
                        $status = "AFK";
                        break;
                    default:
                        $status = "Online";
                endswitch;
                $exec = $bdd->exec('UPDATE tchat_users SET status="' . $status . '" WHERE pseudo = "' . $_SESSION['pseudo'] . '"');
                echo "OK";
            } elseif ($ifmute == 1) {
                echo "FORBIDDDEN";
            } else {
                $exec = $bdd->exec('INSERT INTO tchat(user, message, date, type) value( "' . $_SESSION['pseudo'] . '", "' . smiley($message) . '", "' . time() . '", "J")');
                echo "OK";
            }
        }
    }
}