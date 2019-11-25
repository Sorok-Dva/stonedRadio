<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 15:56
 * @File    : UsersController.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

namespace App\Controller;

use App\Table;
use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;

class UsersController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadModel('User');
        $this->loadModel('Users_Exploit');
    }


    /**
     * @param $password string Encrypte de façon non récursive un mot de passe
     * @return string Le mot de passe enrypté
     */
    public static function cryptPass($password) {
        $encryptedPassword = crypt($password,'$2y$07$wqazsxcedfrvbtghynujkiomp$');
        return $encryptedPassword;
    }

    /**
     * Envoie un mail pour valider l'inscription
     * @param $pseudo string Pseudo (prenom + nom) du nouvel utilisateur
     * @param $mail string Mail du nouvel utilisateur
     */
    private function sendRegistrationMail($pseudo, $mail, $activation){
        $message_mail = "
		<!doctype html>
			<html lang='fr'>
				<head>
					<style>
						html, body{width:100%;margin: 0;background: #f2f2f2;}
						p{width: 500px;background: white;padding: 10px;margin: 10px auto 5px auto;font-family: Arial;font-size: 16px;}
						table{width: 250px;margin: 10px auto 5px auto;}
						a{text-decoration: none;}
						button{display: block;margin: 10px auto 5px auto;background: #3498db;background-image: -webkit-linear-gradient(top, #3498db, #2980b9);background-image: -moz-linear-gradient(top, #3498db, #2980b9);background-image: -ms-linear-gradient(top, #3498db, #2980b9);background-image: -o-linear-gradient(top, #3498db, #2980b9);background-image: linear-gradient(to bottom, #3498db, #2980b9);-webkit-border-radius: 5;-moz-border-radius: 5; border-radius: 5px;font-family: Arial;color: #ffffff;font-size: 16px;padding: 10px 20px 10px 20px;border: solid #1f628d 1px;text-decoration: none;}
						button:hover{background: #3cb0fd;background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);background-image: -o-linear-gradient(top, #3cb0fd, #3498db);background-image: linear-gradient(to bottom, #3cb0fd, #3498db);text-decoration: none;}
					</style>
				</head>
				<body>
					<p><strong>Bonjour ".$pseudo."</strong>,
					<br />merci d'avoir rejoint ". App::getInstance()->name .", pour valider votre inscription il vous suffit de confirmer votre adresse email.</p>
					<a href='".$activation."'>
					<button id='jeconfirme'>Confirmer l'adresse email</button></a>
					<p>Le bouton ne fonctionne pas ? Essayez de coller ce lien dans votre navigateur : ".$activation."</p>
				</body>
			</html>";

        $headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
        $headers_mail .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
        $headers_mail .= 'From: "'.App::getInstance()->name.'" <stoned-radio@noreply.com>' ."\r\n";

        // Envoi du mail
        mail($mail, 'Inscription sur '.App::getInstance()->name.'', $message_mail, $headers_mail);
    }

    /**
     * Function qui permet de vérifier s'il n'existe pas de doublon au niveau des pseudo/mails en base de donnée
     * @param $type string nom de la colonne
     * @param $data string donnée à vérifier
     * @return bool true|false Retourne true si y a pas de doublon, retourne false s'il y en a un
     * @internal param string $var Le contenue de la variable a vérifiée
     */
    private function noDataDuplicate($type, $data){
        if(empty($this->User->checkData($type, $data))) {
            return true;
        }
        return false;
    }

    /**
     * Function qui permet de vérifier s'il n'existe pas de doublon au niveau des pseudo/mails en base de donnée
     * @param $type string nom de la colonne
     * @param $data string donnée à vérifier
     * @return bool true|false Retourne true si y a pas de doublon, retourne false s'il y en a un
     * @internal param string $var Le contenue de la variable a vérifiée
     */
    private function checkData($type, $data){
        if(empty($this->User->checkData($type, $data))) {
            return false;
        }
        return true;
    }

    /**
     * Enregistre un utilisateur après avoir effectuer une batterie de test
     * @return mixed
     */
    public function register(){
        $this->forbiddenToMember();
        if(!empty($_POST)){
            if ($_POST['pseudo'] AND $_POST['password'] AND $_POST['retypePassword'] AND $_POST['sexe'] ) {
                $pseudo = $_POST['pseudo'];
                $password = $_POST['password'];
                $retypePassword = $_POST['retypePassword'];
                $mail = $_POST['mail'];
                $sexe = $_POST['sexe'];

                if ($password == $retypePassword) {
                    $passDoesntMatch = false;
                    if ($this->noDataDuplicate('mail', $mail) == true) {
                        if ($this->noDataDuplicate('pseudo', $pseudo) == true) {
                            $errorDuplicatePseudo = false;
                            $timestamp = time();
                            $user_id = uniqid();
                            $result = $this->User->create([
                                'user_id' => $user_id,
                                'pseudo' =>  ucfirst($pseudo),
                                'password' => $this->cryptPass($password),
                                'mail' => $mail,
                                'points' => "10",
                                'grade' => "Mem",
                                'valider' => "N",
                                'register_ip' => $_SERVER['REMOTE_ADDR'],
                                'sexe' => $sexe,
                                'date_inscription' => time()
                            ]);
                            $result = $this->Users_Exploit->create([
                                'uniq_id' => uniqid(),
                                'user_id' => $user_id,
                                'type' => "New",
                                'lvl' => "Infini",
                                'date1' => time()
                            ]);

                            $activation = "http://localhost/tchat/?page=users.validation&var=".$user_id;
                            $this->sendRegistrationMail($pseudo, $mail, $activation);

                            if(!empty($result)){
                                return $this->result('successR');
                            } else {
                                return $this->result('errorR');
                            }
                        } else {
                            /*
                             * Doublon d'adresse e-mail
                             */
                            $errorDuplicatePseudo = true;
                            $errorDuplicateMail = false;
                            $missingFields = false;
                            $errorDuplicatePseudo = false;
                        }
                    } else {
                        /*
                         * Doublon d'adresse e-mail
                         */
                        $errorDuplicateMail = true;
                        $missingFields = false;
                        $errorDuplicatePseudo = false;
                    }
                } else {
                    $passDoesntMatch = true;
                    $errorDuplicateMail = false;
                    $missingFields = false;
                    $errorDuplicatePseudo = false;
                }
            } else {
                $missingFields = true;
                $passDoesntMatch = false;
                $errorDuplicateMail = false;
                $errorDuplicatePseudo = false;
            }
        } else {
            $missingFields = false;
            $passDoesntMatch = false;
            $errorDuplicateMail = false;
            $errorDuplicatePseudo = false;
        }

        $form = new BootstrapForm($_POST);
        $this->render('users.register', compact('form', 'errorDuplicateMail', 'errorDuplicatePseudo', 'passDoesntMatch', 'missingFields'));
    }

    public function result($info){
        $website =  App::getInstance()->name;
        switch($info):

            case 'successR':
                $successRegister = true;
                $errorRegister = false;
                $success = false;
                $error = false;
                break;
            case 'success':
                $successRegister = false;
                $errorRegister = false;
                $success = true;
                $error = false;
                break;
            case 'errorR':
                $successRegister = false;
                $errorRegister = true;
                $success = false;
                $error = false;
                break;
            case 'error':
                $successRegister = false;
                $errorRegister = false;
                $success = false;
                $error = true;
                break;
        endswitch;

        $this->render('users.result', compact('success', 'error','successRegister', 'errorRegister', 'website'));
        die();
    }

    /**
     * Management d'un utilisateur
     */
    public function manage(){
        $this->forbiddenToVisitor();
        $info = $this->User->find($_SESSION['user_id'], true);
        $uploadAvatarError = false;
        if (!empty($_FILES['avatar'])):
            $taille = @getimagesize($_FILES['avatar']['tmp_name']);
            $modif = false;
            $var = uniqid();

            if (($_FILES['avatar']['size']<(1024*1024)) && ($_FILES['avatar']['error'] == 0) && (($taille['mime'] == 'image/jpg') || ($taille['mime'] == 'image/jpeg') || ($taille['mime'] == 'image/png') || ($taille['mime'] == 'image/gif'))) {
                // *** Conversion ****************** //
                if (($taille['mime'] == 'image/jpg') || ($taille['mime'] == 'image/jpeg')) {
                    $source = imageCreateFromJpeg($_FILES['avatar']['tmp_name']);
                    imagePng($source, $_FILES['avatar']['tmp_name']);
                    $modif = true;
                } else if ($taille['mime'] == 'image/gif') {
                    $source = imageCreateFromGif($_FILES['avatar']['tmp_name']);
                    imagePng($source, $_FILES['avatar']['tmp_name']);
                    $modif = true;
                }
                // LES AVATARS SONT DE 150px/150px
                // *** Réduction ******************* //
                if (($taille[0] > 150) && ($taille[1] > 150)) {

                    // préparation
                    $source = imageCreateFromPng($_FILES['avatar']['tmp_name']);
                    $rapport = $taille[1] / $taille[0];

                    // image de destination
                    $destination = imageCreateTrueColor(150, 150);
                    $blanc = imageColorAllocate($destination, 255, 255, 255);
                    imageFill($destination, 0, 0, $blanc);

                    if ($rapport < 1) {
                        $T = round(150 * $rapport);
                        $Y = round((150 - $T) / 2);
                        imageCopyResampled($destination, $source, 0, $Y, 0, 0, 150, $T, $taille[0], $taille[1]);
                    } else {
                        $T = round(150 / $rapport);
                        $X = round((150 - $T) / 2);
                        imageCopyResampled($destination, $source, $X, 0, 0, 0, $T, 150, $taille[0], $taille[1]);
                    }

                    unset($rapport, $blanc);
                    $modif = true;
                } // *** Recadrage ******************* //
                else if (($taille[0] < 150) && ($taille[1] < 150)) {

                    // préparation
                    $source = imageCreateFromPng($_FILES['avatar']['tmp_name']);

                    // image de destination
                    $destination = imageCreateTrueColor(150, 150);
                    $blanc = imageColorAllocate($destination, 255, 255, 255);
                    imageFill($destination, 0, 0, $blanc);

                    $Y = round((150 - $taille[0]) / 2);
                    $X = round((150 - $taille[1]) / 2);
                    imageCopy($destination, $source, $X, $Y, 0, 0, $taille[0], $taille[1]);

                    unset($blanc, $Y, $X);
                    $modif = true;
                }

                if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/' . $_SESSION['user_id'] . '/avatar/')) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/' . $_SESSION['user_id'], 0705);
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/' . $_SESSION['user_id'] . '/avatar', 0705);
                }
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/'.$info->avatar)){
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/'.$info->avatar);
                }
                if ($modif) {
                    imageDestroy($source);
                    imagePng($destination, $_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/' . $_SESSION['user_id'] . '/avatar/avatar'.$var.'.png');
                } else {
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/app/user_folder/' . $_SESSION['user_id'] . '/avatar/avatar'.$var.'.png');
                }
                $result = $this->User->update($_SESSION['id'], [
                    'avatar' => $_SESSION['user_id'] . '/avatar/avatar'.$var.'.png',
                ]);
                $_SESSION['avatar'] = 'http://stoned-radio.fr/app/user_folder/'.  $_SESSION['user_id'] . '/avatar/avatar'.$var.'.png';
            } else {
                $uploadAvatarError = true;
            }
        endif;

        $dataMember = $this->User->find($_SESSION['id']);
        $form = new BootstrapForm($_POST);
        $this->render('users.manage', compact('form', 'uploadAvatarError', 'dataMember', 'info'));
    }

    /**
     * Connecte un utilisateur
     */
    public function login(){
        $this->forbiddenToMember();
        $errors = false;
        if(!empty($_POST)){
            $auth = new DBAuth(App::getInstance()->getDb());
            if($auth->login($_POST['username'], $_POST['password'])){
                $result = $this->User->update($_SESSION['id'], [
                    'last_login' => time(),
                ]);
                header('Location:?page=users.listenerArea');
            } else {
                $errors = true;
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('users.login', compact('form', 'errors'));
    }

    /**
     * Function pour connecter un utilisateur sans passer par la page de connexion (connexion via la box)
     */
    public function loginInstant(){
        $this->forbiddenToMember();
        if(!empty($_POST)){
            $auth = new DBAuth(App::getInstance()->getDb());
            if($auth->login($_POST['username'], $_POST['password'])){
                $result = $this->User->update($_SESSION['id'], [
                    'last_login' => time(),
                ]);
                header('Location:/');
            } else {
                $errors = true;
                $form = new BootstrapForm($_POST);
                $this->render('users.login', compact('form', 'errors'));
            }
        }
    }

    /**
     * Deconnecte un utilisateur
     */
    public function logout(){
        session_unset();
        session_destroy();

        header('Location: /'); //s'occupe de rediriger l'utilisateur déconnecter vers l'accueil
    }

    /**
     * Récupère la liste des membres
     */
    public function liste(){
        $messagesParPage=20;
        $total=$this->User->getAllUsers();
        $nombreDePages=ceil($total/$messagesParPage);
        if(isset($_GET['p'])) {
            $pageActuelle=intval($_GET['p']);
            if($pageActuelle>$nombreDePages) {
                $pageActuelle=$nombreDePages;
            }
        }
        else {
            $pageActuelle=1;
        }
        $premiereEntree=($pageActuelle-1)*$messagesParPage;
        $resultat=$this->User->getListUser($premiereEntree,$messagesParPage);

        $this->render('users.liste', compact('resultat', 'nombreDePages', 'pageActuelle'));
    }

    /**
     * Pour les auditeurs
     */
    public function listenerArea(){
        $this->forbiddenToVisitor();
        if($_POST):
            if((!empty($_POST['delete'])) AND (!empty($_POST['idToDelete']))):
                $id = $_POST['idToDelete'];
                $this->User->deleteAskedHit($id);
                header('Location:?page=users.listenerArea');
            endif;
            if((!empty($_POST['artiste'])) AND (!empty($_POST['titre']))):
                $artiste = $_POST['artiste'];
                $titre = $_POST['titre'];
                if ($this->User->rowHitsUser() <= 120){
                    $this->User->createAskedHit($artiste, $titre);
                    header('Location:?page=users.listenerArea');
                } else {
                    $erreur = '<div class="alert alert-danger alert-dismissible" role="alert">Vous avez fait trop de demandes de musiques...</div>';
                }
            endif;
        endif;
        if($this->User->rowHitsUser() === 0) {
            $erreur = "<div class=\"alert alert-info\" role=\"alert\">Vous n'avez pas encore proposé de musique... Pour en proposer une, remplissez le formulaire ci dessus.</div>";
        } else {
            $askedHits = $this->User->getHitsUser();
            $erreur = false;
        }
        $this->render('users.listenerArea', compact('erreur', 'askedHits'));
    }

    /**
     * Pour les animateurs
     */
    public function animatorArea(){
        $this->forbiddenToVisitor();
        if((!empty($_SESSION)) AND ($_SESSION['grade'] == "Anim") OR ($_SESSION['grade'] == "Admin") OR ($_SESSION['grade'] == "Dev")){

            $this->render('users.animatorArea');
        }else {
            header('Location:?page=users.listenerArea');
        }
    }

    /**
     * Pour récuperer son mot de passe
     */
    public function recoveryPassword(){
        $this->forbiddenToMember();
        if((!empty($_POST['pseudo'])) AND (!empty($_POST['mail']))) {

            if($this->User->verifRecoveryPassword($_POST['pseudo'], $_POST['mail'])){
                $generateKey = crypt($_POST['mail'].uniqid().$_POST['pseudo'],'$2y$07$StonedRadioRecoveryPassword$');
                $destinataire = $_POST['mail'];
                $email = 'no-reply@stoned-radio.fr';
                $headers  = 'MIME-Version: 1.0'                           ."\r\n";
                $headers .= "From: <".$email.">\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
                $sujet = 'Oublie mot de passe, Stoned-radio.fr';
                $message = '
                    Bonjour,<br />
                    Pour récupérer votre mot de passe, veuillez cliquer <a href="http://www.stoned-radio.fr/?page=users.newPassword&key='.$generateKey.'">ici</a>.<br />
                    Si vous ne pouvez pas cliquer sur ce lien, veuillez entrer cette adresse <strong>http://www.stoned-radio.fr/?page=users.newPassword&key='.$generateKey.'</strong> dans une barre URL.<br /><br />
                    Cordialement,<br />
                    L\'équipe Stoned-Radio.<br /><br />
                    <i>Ceci est un e-mail envoyé automatiquement, merci de ne pas y répondre, les réponses ne sont pas consultées.</i>
                    ';
                if(mail($destinataire,$sujet,$message,$headers))
                {
                    $this->User-> insertKeyForNewPass($_POST['pseudo'], $generateKey);
                    $info = '<div class="alert alert-success alert-dismissible" role="alert">
	                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Un email a bien été envoyé à l\'adresse '.$_POST['mail'].'.</div>';
                }
                else
                {
                    $info = '<div class="alert alert-danger alert-dismissible" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Le mail n\'a pas pu être envoyé, veuillez réessayez.</div>';
                }
            }
            else
            {
                $info = '<div class="alert alert-danger alert-dismissible" role="alert">
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>L\'email ne correspond pas au pseudo.</div>';
            }
        }
        $this->render('users.recoveryPassword', compact('info'));
    }

    /**
     * Pour modifier son mot de passe
     */
    public function newPassword(){
        $this->forbiddenToMember();
        if(!empty($_POST)){
            if($_POST['mdp'] && $_POST['mdp2']) {
                if($_POST['mdp'] == $_POST['mdp2']) {
                    $verif = $this->User->verifKeyForNewPass($_GET['key']);
                    if($verif){
//                        var_dump($verif);
                        $password = $this->cryptPass($_POST['mdp']);
                        $info =  '<div class="alert alert-success alert-dismissible" role="alert">
	                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Le mot de passe a bien été changé. <a href="?page=users.login">Se connecter</a></div>';
                        $this->User->deleteKey($_GET['key']);
                        $this->User->updatePassword($password, $verif[0]->pseudo);


                    }
                }
                else
                {
                    $info = '<div class="alert alert-danger alert-dismissible" role="alert">
	                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Les deux mots de passe sont différents.</div>';
                }
            }

            $this->render('users.newPassword', compact('info'));
        } else {
            if(empty($_GET['key'])){
                header('Location:/');
            } else {
                if($this->User->verifKeyForNewPass($_GET['key'])){
                    $this->render('users.newPassword');
                } else {
                    header('Location:/');
                }
            }
        }
    }
}