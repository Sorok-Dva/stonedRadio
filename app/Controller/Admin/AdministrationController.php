<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 13:42
 * @File    : AdministrationController.php
 * @Version : 1.0
 */
namespace App\Controller\Admin;

use App;
use Core\HTML\bootstrapForm;
use Core\Controller\Controller;

class AdministrationController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('admin.index');
    }
}