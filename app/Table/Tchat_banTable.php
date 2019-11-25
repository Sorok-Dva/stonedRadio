<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 12:33
 * @File    : Tchat_banTable.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

namespace App\Table;
use \Core\Table\Table;

class Tchat_banTable extends Table {

    public function isBan(){
        return $this->query("SELECT * FROM tchat_bans WHERE user = '{$_SESSION['pseudo']}'");
    }
}