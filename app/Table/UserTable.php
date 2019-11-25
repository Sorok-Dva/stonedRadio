<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 16/07/2015
 * @Time    : 16:05
 * @File    : UserTable.php
 * @Version : 1.0
 * @Todo    : � completer!
 */

namespace App\Table;
use \Core\Table\Table;


class UserTable extends Table {

    public function checkData($type, $data){
        return $this->query("SELECT * FROM users WHERE {$type} = '{$data}'");
    }

    public function getAllUsers(){
        return $this->query("SELECT * FROM users", null, true, false);
    }

    public function getListUser($premiereEntree,$messagesParPage){
        return $this->query("SELECT * FROM users ORDER BY id DESC LIMIT {$premiereEntree}, {$messagesParPage}");
    }

    public function rowHitsUser(){
        return $this->query("SELECT * FROM hit_auditeur WHERE compte='{$_SESSION['pseudo']}' ORDER BY id DESC", null, true, false);
    }

    public function getHitsUser(){
        return $this->query("SELECT * FROM hit_auditeur WHERE compte='{$_SESSION['pseudo']}' ORDER BY id DESC");
    }

    public function deleteAskedHit($id){
        return $this->query("DELETE FROM hit_auditeur WHERE id = ?", [$id], false, true);
    }

    public function createAskedHit($artiste, $titre){
        return $this->query("INSERT INTO hit_auditeur VALUES('', '{$artiste}', '{$titre}', '{$_SESSION['pseudo']}')");
    }

    public function verifRecoveryPassword($pseudo, $mail){
        return $this->query("SELECT * FROM users WHERE pseudo='{$pseudo}' and mail='{$mail}'");
    }

    public function insertKeyForNewPass($pseudo, $key){
        return $this->query("INSERT INTO mdp VALUES('', '{$pseudo}', '{$key}')");
    }

    public function verifKeyForNewPass($key){
        return $this->query("SELECT * FROM mdp WHERE cle='{$key}'");
    }

    public function deleteKey($key){
        return $this->query("DELETE FROM mdp WHERE cle='{$key}'");
    }

    public function updatePassword($password, $pseudo){
        return $this->query("UPDATE users SET password='{$password}' WHERE pseudo='{$pseudo}'", null, false, true);
    }

}