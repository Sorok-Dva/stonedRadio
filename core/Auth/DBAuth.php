<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 17/07/2015
 * @Time    : 12:21
 * @File    : DBAuth.php
 * @Version : 1.0
 * @Todo    : À completer!
 */

namespace Core\Auth;

use App\Controller\UsersController;
use Core\Database\Database;

class DBAuth {

    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getUserId(){
        if ($this->logged()){
            return $_SESSION['id'];
        }
        return false;
    }

    /**
     * @param $username
     * @param $password
     * @ereturn boolean
     * @return bool
     */
    public function login($username, $password) {
        $user = $this->db->prepare("SELECT * FROM users WHERE pseudo = ? AND deleted = 'N'", [$username], null, true);
        $checkBan = $this->db->prepare("SELECT * FROM ban WHERE compte_banni = ?", [$user->pseudo], null, true);
        if(!$checkBan){
            if($user) {
                /**
                 * Gestion de MAJ des mots de passe vers le nouvel encryptage
                 */
                if($user->oldPassword === md5($password)) {
                    updateOldPassword(UsersController::cryptPass($password), $user->user_id);
                }
                if($user->password === UsersController::cryptPass($password)) {
                    $_SESSION['id'] = $user->id;
                    $_SESSION['pseudo'] = $user->pseudo;
                    $_SESSION['grade'] = $user->grade;
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['avatar'] = 'http://stoned-radio.fr/app/user_folder/'. $user->avatar;

                    return true;
                }
            }
        }

            return false;
    }

    public function logged(){
        return isset($_SESSION['id']);
    }
}