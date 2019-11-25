<?php
/**
 * @Author  : Created by Llyam Garcia.
 * @Nick    : Liightman
 * @Date    : 16/07/2015
 * @Time    : 15:07
 * @File    : Config.php
 * @Version : 1.0
 * @Todo    : � completer!
 */

namespace Core;


class Config {

    /**
     * @var string À ne pas toucher. Ce framework n'est pas OpenSource et appartient donc de droit à Llyam Garcia
     */
    public static $author = "<small>Developped and powered by a framework created by Llyam Garcia as Liightman</small>";
    private $settings = [];
    private static $_instance;

    public static function getInstance($file) {
        if(is_null(self::$_instance)) {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    public function __construct($file) {
        $this->settings = require($file);
    }

    public function get($key) {
        if(!isset($this->settings[$key])) {
            return null;
        }

        return $this->settings[$key];
    }
}