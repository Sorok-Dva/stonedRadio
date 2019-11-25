<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 12:50
 * @File    : ReplayTable.php
 * @Version : 1.0
 */

namespace App\Table;
use \Core\Table\Table;

class ReplayTable extends Table {

    protected $table = "replay";

    public function selection(){
        return $this->query("SELECT * FROM replay", null, true, false);
    }

    public function getReplay($premiereEntree,$messagesParPage){
        return $this->query("SELECT * FROM replay ORDER BY id DESC LIMIT {$premiereEntree}, {$messagesParPage}");
    }
}