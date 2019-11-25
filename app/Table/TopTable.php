<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 14:15
 * @File    : TopTable.php
 * @Version : 1.0
 */

namespace App\Table;
use \Core\Table\Table;

class TopTable extends Table {
    public function getTop15(){
        return $this->query("SELECT * FROM classement ORDER BY pour DESC LIMIT 0,15");
    }
}