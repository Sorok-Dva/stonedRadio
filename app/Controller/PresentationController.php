<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 11/09/2015
 * @Time    : 19:40
 * @File    : PresentationController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use \App;

class PresentationController extends AppController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Présentation de la radio
     */
    public function radio() {
        $this->render('presentation.radio');
    }

    /**
     * Présentation des animateurs
     */
    public function animateurs() {
        $this->render('presentation.animateurs');
    }
}