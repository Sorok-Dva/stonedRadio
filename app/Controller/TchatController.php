<?php

/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 12/08/2015
 * @Time    : 17:03
 * @File    : TchatController.php
 * @Version : 1.0
 */
namespace App\Controller;

use App\Table;
use \App;

class TchatController extends AppController{

    public function __construct() {
        parent::__construct();
        $this->loadModel('Tchat_user');
        $this->loadModel('Tchat_kick');
        $this->loadModel('Tchat_ban');
        $this->loadModel('Tchat');
    }

    public function view(){;
        $this->forbiddenToVisitor();
        if(!empty($this->Tchat_ban->isBan())) {
            $ban  = $this->Tchat_ban->isBan();
            $this->render('tchat.ban', compact('ban'));
        } else {
            if(empty($this->Tchat_user->login())){
                if(!empty($_SESSION)){
                    $result = $this->Tchat->create([
                        'message' => "<b>".$_SESSION['pseudo']."</b> est entré dans le salon.",
                        'date' =>  time(),
                        'type' => "I"
                    ]);
                    $result = $this->Tchat_user->create([
                        'user_id' => $_SESSION['user_id'],
                        'pseudo' =>  $_SESSION['pseudo'],
                        'last_msg' => time()
                    ]);
                }
            }
            $this->render('tchat.view');
        }
    }

    public function kick(){;
        $this->forbiddenToVisitor();
        $kick =$this->Tchat_kick->last();
        $this->render('tchat.kick', compact('kick'));
    }

/*    public function logout(){;
        $this->forbiddenToVisitor();
        $this->render('tchat.logout');
    }*/
}