<?php

namespace Neoan3\Apps;

use Exception;

/**
 * Class Session
 * @package Neoan3\Apps
 */
class Session
{
    private static string $prefix;
    private static int $expireInSeconds;
    /**
     * Session constructor.
     * @param string $prefix
     * @param int $expireInSeconds
     */
    function __construct($prefix = 'neoan3-', $expireInSeconds = 1800)
    {

        self::$expireInSeconds = $expireInSeconds;
        self::$prefix = $prefix;
        if (session_status() == PHP_SESSION_NONE) {
            ini_set('session.use_strict_mode', 1);
            session_start();
        }
        if(self::isLoggedIn() && !self::status()){
            // expired
            self::logout();
        }
    }


    /**
     * @return mixed
     */
    static function userId()
    {
        return $_SESSION['logged_id'];
    }

    /**
     * @param ?array $scope
     * @return array
     * @throws Exception
     */
    static function restrict(array $scope = null)
    {
        if(!self::status() || !self::scopeCheck($scope)){
            throw new Exception('Not allowed');
        }
        return self::getUserSession();
    }



    /**
     * @return bool
     */
    static function isLoggedIn()
    {
        if (!isset($_SESSION['logged_id'])) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param        $user_id
     * @param array  $scope
     * @param string $userType
     */
    static function login($user_id, array $scope = [], $userType = 'user')
    {
        //create SESSION
        $sessionId = session_create_id(self::$prefix);
        session_commit();
        session_id($sessionId);
        session_start();
        $_SESSION['logged_id'] = $user_id;
        $_SESSION['expires'] = time() + self::$expireInSeconds;
        $template = [
            'user' => ['id' => $user_id, 'user_type' => $userType],
            'scope' => $scope,
            'payload' => []
        ];
        self::addToSession($template);
    }

    static function getUserSession()
    {
        return $_SESSION;
    }

    /**
     * @param $array
     */
    static function addToSession($array)
    {
        foreach ($array as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    /**
     *
     */
    static function logout()
    {
        //destroy session
        if(isset($_SESSION['logged_id'])){
            unset($_SESSION['logged_id']);
        }
        @session_unset();
        @session_destroy();
        @session_write_close();

    }

    static function status():bool
    {
        $now = time();
        return self::isLoggedIn() && $now < $_SESSION['expires'];
    }

    /**
     * @param ?string|array $roles
     *
     * @return bool
     */
    static function scopeCheck($roles = null)
    {
        $allow = true;
        if($roles){
            $allow = false;
            foreach ($_SESSION['scope'] as $user_scope) {
                if (is_array($roles)) {
                    foreach ($roles as $sRole) {
                        if ($user_scope == $sRole) {
                            $allow = true;
                        }
                    }
                } elseif ($user_scope == $roles) {
                    $allow = true;
                }
            }
        }

        return $allow;
    }

}
