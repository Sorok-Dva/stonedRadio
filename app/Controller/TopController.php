<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 14:13
 * @File    : TopController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use \App;

class TopController extends AppController{

    public function __construct() {
        parent::__construct();
        $this->loadModel('Top');
    }

    public function hits(){;
        $hits = $this->Top->getTop15();
        $this->render('top.hits', compact('hits'));
    }

}