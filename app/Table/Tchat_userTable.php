<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 12/08/2015
 * @Time    : 23:06
 * @File    : Tchat_userTable.php
 * @Version : 1.0
 */

namespace App\Table;
use \Core\Table\Table;

class Tchat_userTable extends Table {

    public function login(){
        return $this->query("SELECT * FROM tchat_users WHERE pseudo = '{$_SESSION['pseudo']}'");
    }
}