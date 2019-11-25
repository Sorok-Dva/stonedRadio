<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 12:23
 * @File    : PlanningController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use \App;

class PlanningController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('planning.index');
    }
}

?>