<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 04/10/2015
 * @Time    : 19:22
 * @File    : RadioController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;

class RadioController extends AppController{

    public function __construct(){
        parent::__construct();
    }

    public function listen(){
        $this->render('radio.listen');
    }
}