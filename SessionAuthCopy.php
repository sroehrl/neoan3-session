<?php


namespace Neoan3\Apps;


interface SessionAuthCopy
{
    public function setSecret(string $string): void;
    public function validate(?string $jwt):SessionAuthObjectCopy;
    public function restrict($scope):SessionAuthObjectCopy;
    public function assign($id, $scope, $payload = []):SessionAuthObjectCopy;
}