<?php

/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 06/10/2015
 * @Time    : 10:09
 * @File    : tp_minichat.php
 * @Version : 1.0
 */

ini_set('display_errors',1);
error_reporting(E_ALL);

try {
    $dbname = 'tchat';
    $user = 'root';
    $server = 'localhost';
    $pass = '';
    $bdd = new PDO ('mysql:host=' . $server . ';dbname=' .$dbname, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
    die();
}

if($_POST):
    if(!empty($_POST['pseudo']) AND (!empty($_POST['message']))){
        $pseudo =  strip_tags($_POST['pseudo']);
        $message = strip_tags($_POST['message']);

        $insert = $bdd->prepare("INSERT INTO tp_minichat (pseudo, message, date) VALUES (:pseudo, :message, :date)");
        $execution = $insert->execute([
            ":pseudo" => $pseudo,
            ":message" => $message,
            ":date" => time()
        ]);
    }
endif;