<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 15:51
 * @File    : NewsController.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

namespace App\Controller\Admin;

use App;
use Core\HTML\bootstrapForm;
use Core\Controller\Controller;

class NewsController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('New');
    }

    /**
     * Page d'accueil qui liste les news/articles
     */
    public function index(){
        App::getInstance()->menuActive = "1";
        $news =$this->New->all();
        $this->render('admin.news.index', compact('news'));
    }

    public function categories(){

    }

    public function add(){
        App::getInstance()->menuActive = "2";
        $title = "Créer un article / une news";
        if(!empty($_POST)){
            $result = $this->New->create([
                'titre' => $_POST['titre'],
                'contenu' => $_POST['contenu'],
                'auteur' => $_SESSION['auth'],
                'date' => date("Y-m-d H:i:s")
            ]);
        }
        if(!empty($result)){
            return $this->index();
        }
        $form = new bootstrapForm($_POST);
        $this->render('admin.news.edit', compact('form', 'title'));
    }

    public function edit(){
        App::getInstance()->menuActive = "3";
        $title = "Edition de la news n°" . $_GET['id'];
        if(!empty($_New)){
            $result = $this->New->update($_GET['id'], [
                'titre' => $_POST['titre'],
                'contenu' => $_POST['contenu']
            ]);
        }
        if(!empty($result)){
           return $this->index();
        }

        $news = $this->New->find($_GET['id']);
        $form = new bootstrapForm($news);
        $this->render('admin.news.edit', compact('form', 'title'));
    }

    public function delete(){
        if(!empty($_POST)){
            $result = $this->New->delete($_POST['id']);
            return $this->index();
        }

    }


}