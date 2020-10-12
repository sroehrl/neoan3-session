<?php


namespace Neoan3\Apps;


interface SessionAuthObjectCopy
{
    public function __construct(string $userId, array $scope);
    public function setScope(array $scope): void;
    public function getScope(): array;
    public function setUserId(string $userId): void;
    public function getUserId(): string;
    public function setPayload(array $payload): void;
    public function getPayload(): array;
    public function __toString(): string;
}