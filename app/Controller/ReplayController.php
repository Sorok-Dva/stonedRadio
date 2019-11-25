<?php
/**
 * @Author  : Created by Llyam GARCIA.
 * @Nick    : Liightman
 * @Date    : 03/10/2015
 * @Time    : 12:58
 * @File    : ReplayController.php
 * @Version : 1.0
 */

namespace App\Controller;

use App\Table;
use Core\HTML\BootstrapForm;
use \App;

class ReplayController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('Replay');
    }

    public function index() {

        $messagesParPage=3;

        $total=$this->Replay->selection();
        $nombreDePages=ceil($total/$messagesParPage);

        if(isset($_GET['p']))
        {
            $pageActuelle=intval($_GET['p']);

            if($pageActuelle>$nombreDePages)
            {
                $pageActuelle=$nombreDePages;
            }
        }
        else
        {
            $pageActuelle=1;
        }
        $premiereEntree=($pageActuelle-1)*$messagesParPage;

        $resultat=$this->Replay->getReplay($premiereEntree,$messagesParPage);

        $this->render('replay.index', compact('resultat', 'nombreDePages', 'pageActuelle'));
    }
}