<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 12:23
 * @File    : Tchat_kickTable.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

namespace App\Table;
use \Core\Table\Table;

class Tchat_kickTable extends Table {

    public function last(){
        return $this->query("SELECT * FROM tchat_kicks WHERE pseudo = '{$_SESSION['pseudo']}' ORDER BY date DESC LIMIT 0,1");
    }
}