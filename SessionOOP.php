<?php


namespace Neoan3\Apps;


use Exception;

class SessionOOP  implements SessionAuthCopy
{

    public function setSecret(string $string): void
    {
        new Session($string);
    }

    /**
     * @param string|null $provided
     * @return SessionAuthObject
     * @throws Exception
     */
    public function validate(?string $provided = null): SessionAuthObject
    {
        if(Session::isLoggedIn()){
            $user = Session::getUserSession();
            return new SessionAuthObject($user['logged_id'], $user['scope']);
        } else {
            throw new Exception('Unauthenticated', 401);
        }
    }

    /**
     * @param string|array|null $scope
     * @return SessionAuthObject
     * @throws Exception
     */
    public function restrict($scope=null): SessionAuthObject
    {
        $trueScope = is_array($scope) ? $scope : ($scope ? [$scope] : null);
        Session::restrict($trueScope);
        return $this->validate();
    }

    /**
     * @param $id
     * @param $scope
     * @param array $payload
     * @return SessionAuthObject
     * @throws Exception
     */
    public function assign($id, $scope, $payload = []): SessionAuthObject
    {
        Session::login($id,$scope);
        if(!empty($payload)){
            Session::addToSession(['payload'=>$payload]);
        }
        return $this->validate();
    }
    public function logout(): bool
    {
        Session::logout();
        return true;
    }

}