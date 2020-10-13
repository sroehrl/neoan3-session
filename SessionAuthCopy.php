<?php


namespace Neoan3\Apps;


interface SessionAuthCopy
{
    public function setSecret(string $string): void;
    public function validate(?string $jwt = null):SessionAuthObjectCopy;
    public function restrict($scope = []):SessionAuthObjectCopy;
    public function assign($id, $scope, $payload = []):SessionAuthObjectCopy;
    public function logout(): bool;
}