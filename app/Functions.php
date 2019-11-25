<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 14/08/2015
 * @Time    : 13:22
 * @File    : Functions.php
 * @Version : 1.0
 * @Todo    : À completer!
 */
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

function updateOldPassword($password, $user_id){
    global $bdd;
    $result = $bdd->exec("UPDATE users SET password = '{$password}' WHERE user_id='{$user_id}'");
    $result = $bdd->exec("UPDATE users SET oldPassword = NULL WHERE user_id='{$user_id}'");
}

function getPseudo($idPseudo) {
    global $bdd;
    $requete = $bdd->query('SELECT * FROM users WHERE user_id="'.$idPseudo.'"');
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    $rang = $resultat['grade'];
    $sexe = $resultat['sexe'];

    switch($rang) {
        case "Ban":
            $pseudoPerId = "<span style='color: darkred'>".$resultat['pseudo']."</span>";
            break;
        case "Mem":
            if ($sexe == "H") {
                $pseudoPerId = "<span style='color: blue'>".$resultat['pseudo']."</span>";
            } else {
                $pseudoPerId = "<span style='color: rgb(255, 0, 184);'>".$resultat['pseudo']."</span>";
            }
            break;
        case "VIP":
            $pseudoPerId = "<span style='color: orange'>".$resultat['pseudo']."</span>";
            break;
        case "Mod":
            $pseudoPerId = "<span style='color: green'>".$resultat['pseudo']."</span>";
            break;
        case "Adm":
            $pseudoPerId = "<span style='color: red'>".$resultat['pseudo']."</span>";
            break;
        default:
            $pseudoPerId = "<span style='color: black'>".$resultat['pseudo']."</span>";
            break;

    }
    return $pseudoPerId;

}

function getExploitId($type, $user_id){
    global $bdd;

    $requete = $bdd->query("SELECT * FROM users_exploits WHERE type='{$type}' AND user_id='{$user_id}'");
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat['id'];
}

function updateActualExploit($success, $actual){
    global $bdd;

    $requete = $bdd->query("SELECT * FROM users_exploits WHERE type='{$success}' AND user_id='{$_SESSION['user_id']}'");
    $resultat = $requete->fetch();

    if($resultat['actual'] != $actual):
        $update = $bdd->exec("UPDATE users_exploits SET actual = '{$actual}' WHERE type='{$success}' AND user_id='{$_SESSION['user_id']}'");
    endif;
}
function successExploit($success, $lvl){

}

function updateActualDedi(){
    global $bdd;
    $req = $bdd->query("SELECT * FROM dedi_v2 WHERE pseudo = '".$_SESSION['pseudo']."' ");
    $res = $req->rowCount();
    updateActualExploit('Dedi', $res);
}

function getTop5(){
    global $bdd;
    $requete = $bdd->query("SELECT * FROM classement ORDER BY pour DESC LIMIT 5");
    $resultat = $requete->fetchAll();
    $i = 1;
    foreach ($resultat as $hit):
        ?>
        <table>
            <tr>
                <td>
                    <img src="<?= $hit['cover'] ?>" width="80" height="80" />
                </td>
                <td valign="top" style="padding-left:10px;padding-top:5px;">
                    <font color="#444444"><strong><?= $hit['artiste'] ?></strong></font>
                    <br />
                    <div style="height:3px;"> </div>
                    <?= $hit['titre'] ?>
                </td>
            </tr>
        </table>
        <?php
        if($i != 5){
            echo "<br />";
        }
        $i++;

    endforeach;
}

function getLastRegisters(){
    global $bdd;
    $requete = $bdd->query("SELECT * FROM users ORDER BY id DESC LIMIT 5");
    $resultat = $requete->fetchAll();

    foreach ($resultat as $member){
        ?>
        <div class="well well-sm">
            <table width="100%">
				<tr>
					<td width="65%">
                        <div class="membre">
                            <span class="user"><?= $member['pseudo'] ?></span>
                        </div>
					</td>
				</tr>
			</table>
        </div>
        <?php


    }
}