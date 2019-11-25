<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 14:01
 * @File    : ShowController.php
 * @Version : 1.0
 */

namespace App\Controller\Admin;

use App;
use Core\HTML\bootstrapForm;
use Core\Controller\Controller;

class ShowController extends AppController
{
    public function __construct() {
        parent::__construct();
        $this->loadModel('User');
    }

    public function dedicasses() {
        $this->render('admin.dedicasses');
    }

    public function users() {
        $users = $this->User->getAllUsers();
        $this->render('admin.users', compact('users'));
    }

    public function stats() {
        $this->render('admin.stats');
    }
}