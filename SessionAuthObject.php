<?php


namespace Neoan3\Apps;


use Exception;

class SessionAuthObject implements SessionAuthObjectCopy
{
    private string $userId;
    private array $scope;
    public function __construct(string $userId, array $scope)
    {
        $this->setUserId($userId);
        $this->setScope($scope);
    }
    public function __toString(): string
    {
        return 'PHP Session';
    }

    public function setScope(array $scope): void
    {
        $this->scope = $scope;
    }
    public function getScope(): array
    {
        return $this->scope;
    }
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
    public function getUserId(): string
    {
        return $this->userId;
    }


    public function setPayload(array $payload): void
    {
        Session::addToSession($payload);
    }

    public function getPayload(): array
    {
        return Session::getUserSession()['payload'];
    }
}