<?php

namespace Neoan3\Apps;
use Neoan3\Apps\Db;

/**
 * Class Session
 * @package Neoan3\Apps
 */
class Session {
    /**
     * Session constructor.
     */
    function __construct() {
        if(!isset($_SESSION) || !($_SESSION) || empty($_SESSION)) {
            session_start();
        }
    }

    /**
     * @param bool $role
     * @return mixed
     */
    static function api_restricted($role=false){
        if (!isset($_SESSION['logged_id'])){
            echo json_encode(array('error'=>'login'));
            die();
        } elseif($role&&self::roleCheck($role)){
            echo json_encode(array('error'=>'permission denied'));
            die();
        }
        $_SESSION['idle'] = 0;
        return $_SESSION['logged_id'];
    }

    /**
     * @param $label_id
     */
    static function api_admin_restricted($label_id){
        if (!isset($_SESSION['logged_id'])){
            echo json_encode(array('error'=>'login'));
            die();
        }
        $adm = Db::ask('?user',array('id'),array('id'=>$_SESSION['logged_id'], 'user_type'=>'admin', 'label_id'=>$label_id, 'delete_date'=>''));
        if(empty($adm)){
            echo json_encode(array('error'=>'permission'));
            die();
        }
    }

    /**
     *
     */
    static function admin_restricted(){
        if (!isset($_SESSION['logged_id'])){
            redirect(default_ctrl);
            exit();
        }
        $adm = Db::ask('?user',array('id'),array('id'=>$_SESSION['logged_id'], 'user_type'=>'admin', 'delete_date'=>''));
        if(empty($adm)){
            redirect(default_ctrl);
            exit();
        }

    }

    /**
     * @return mixed
     */
    static function user_id(){
        return $_SESSION['logged_id'];
    }

    /**
     * @param bool $role
     */
    static function restricted($role=false) {

        if (!isset($_SESSION['logged_id'])){
            $redirect = $_SERVER['HTTPS']==80?'https://':'http://';
            $redirect .= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            setcookie('redirect',$redirect, time()+60*4,'/');
            redirect(default_ctrl);
            exit();
        } elseif($role){
            if(self::roleCheck($role)){
                echo 'You do not have required permissions to enter this page.';
                die();
            }
        }

    }

    /**
     *
     */
    static function confirmed_restricted() {
        if (!isset($_SESSION['logged_id']) || empty($_SESSION['user']['user_email']['confirm_date']) ){
            redirect('start');
            exit();
        }
    }

    /**
     * @return bool
     */
    static function is_logged_in() {
        if (!isset($_SESSION['logged_id'])){
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param $user_id
     */
    static function login($user_id)  {
        //create SESSION
        $_SESSION['logged_id'] = $user_id;
    }

    /**
     * @param $array
     */
    static function add_session($array) {
        foreach ($array as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    /**
     *
     */
    static function logout()  {

        //destroy session
        unset($_SESSION['logged_id']);
        session_unset();
        session_destroy();
        session_write_close();
    }

    /**
     * @param $role
     * @return bool
     */
    private static function roleCheck($role){
        $block = true;
        foreach($_SESSION['user']['roles'] as $user_role){
            if(is_array($role)){
                foreach ($role as $sRole){
                    if($user_role['role']==$sRole){
                        $block = false;
                    }
                }
            } elseif($user_role['role']==$role){
                $block = false;
            }
        }
        return $block;
    }
}