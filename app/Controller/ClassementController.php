<?php
/**
 * @Author  : Created by Anthony POMMERET.
 * @Nick    : Antho06
 * @Date    : 12/09/2015
 * @Time    : 19:58
 * @File    : ClassementController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use Core\HTML\BootstrapForm;
use \App;

class ClassementController extends AppController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->render('classement.index');
    }
}