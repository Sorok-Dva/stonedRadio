<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 13/08/2015
 * @Time    : 12:03
 * @File    : TchatTable.php
 * @Version : 1.0
 * @Todo    : � completer!
 */

namespace App\Table;
use \Core\Table\Table;

class TchatTable extends Table {

    /**
     * @var string Etant donn� qu'on a une fonction qui se charge de prendre le nom de la classe (au singulier) puis d'y rajouter un "s" afin de r�cup�rer le table
     * il peut y avoir certains cas comme celui de Category qui ne fonctionnent pas �tant donn� que si on laisse tel quel, le nom de la table retourn� serais : "categorys"
     * Donc on redefinit la $table directement
     */
    protected $table = "tchat";
}