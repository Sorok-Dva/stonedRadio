<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 16:22
 * @File    : update.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
/**
 * Connexion à la base de donnée (PROVISOIRE, LE TEMPS QUE JE TROUVE UNE SOLUTION PLUS PROPRE)
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


$reqCompte = $bdd->query('SELECT * FROM membres');
$fetch = $reqCompte->fetchAll();

foreach ($fetch as $update){

    if(($update['ip'] == "86.69.250.138") OR ($update['ip'] == "85.171.120.29") OR ($update['ip'] == "82.232.65.9")) {
        echo "echec<br>";
    } else {
//        if($update['ip'] == "81.67.187.182"):
        $insert = $bdd->prepare("INSERT INTO users (user_id, pseudo, oldPassword, mail, points, register_ip, date_inscription, last_login, valider) VALUES (:user_id, :pseudo, :oldPassword, :mail, :points, :register_ip, :date_inscription, :last_login, :valider)");
        $user_id = uniqid();
        $execute = $insert->execute([
            ':user_id' => $user_id,
            ':pseudo' => ucfirst($update['pseudo']),
            ':oldPassword' => $update['mdp'],
            ':mail' => $update['email'],
            ':points' => "10",
            ':register_ip' => $update['ip'],
            ':date_inscription' => $update['date'],
            ':last_login' => $update['last'],
            ':valider' => "N"
        ]);

        $createExploit = $bdd->prepare("INSERT INTO users_exploits (uniq_id, user_id, type, lvl, date1) VALUES (:uniq_id, :user_id, :type, :lvl, :date1)");
        $execexploit = $createExploit->execute([
            ':uniq_id' => uniqid(),
            ':user_id' => $user_id,
            ':type' => "New",
            ':lvl' => "Infini",
            ':date1' => $update['date']
        ]);
        echo "ok<br>";
//        endif;
    }

}