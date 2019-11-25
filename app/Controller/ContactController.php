<?php
/**
 * @Author  : Created by Anthony POMMERET.
 * @Nick    : Antho06
 * @Date    : 12/09/2015
 * @Time    : 10:50
 * @File    : ContactController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use Core\HTML\BootstrapForm;
use \App;

class ContactController extends AppController {

    public function __construct() {
        parent::__construct();
    }
	
	/**
     * CONTACT
     */
    public function index() {
        $this->render('contact.index');
    }
}