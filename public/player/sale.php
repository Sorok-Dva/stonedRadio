<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 12:17
 * @File    : sale.php
 * @Version : 1.0
 * DESC     : Ce document est sale et je nie en être l'auteur! (Plus sérieusement, je fait ça pour me faciliter la vie parce que la flemme de tout refaire
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
$selectemission = $bdd->query('SELECT direct FROM direct_v3');
$dataemission = $selectemission->fetch();

if($dataemission['direct']==1)
{
    echo "La libre antenne Le Stoned";
}
elseif($dataemission['direct']==2)
{
    echo "The Stoned Song";
}
elseif($dataemission['direct']==3)
{
    echo "Musicalement Historique";
}
elseif($dataemission['direct']==4)
{
    echo "Open Space";
}
elseif($dataemission['direct']==5)
{
    echo "Rediffusion Le Stoned";
}
else
{
    echo "Tous tes hits préférés";
}