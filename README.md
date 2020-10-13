# neoan3 basic session handling

This class handles basic PHP-session requirements and is designed to play nicely with a neoan3 setup.

[![Maintainability](https://api.codeclimate.com/v1/badges/e2f2aafd0ca17882fed8/maintainability)](https://codeclimate.com/github/sroehrl/neoan3-session/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/e2f2aafd0ca17882fed8/test_coverage)](https://codeclimate.com/github/sroehrl/neoan3-session/test_coverage)
[![Build Status](https://travis-ci.com/sroehrl/neoan3-session.svg?branch=master)](https://travis-ci.com/sroehrl/neoan3-session)

## Installation
`composer require neoan3-apps/session`

## Implementation

Create a new Session as early as possible in your code with:

`new \Neoan3\Apps\Session();`

Also check out playground for an OOP example.

## Usage

`Session::login($userId [,$scope=[], $payload =[]])`

Registers a user with the following template

```PHP
[
    'user' => ['id' => $userId, 'user_type' => 'user'],
    'scope' => $scope,
    'payload' => $payload
];
```

`Session::logout()`

Terminates all session variables

`Session::addToSession($array)`

Adds multiple variables to payload using an associative array.

`Session::restrict($array||null)`

Checks if user is logged in and (if parameter is set) whether the user belongs to 
- ONE OF the roles in the given array

and throws an exception is the condition is not met


**NOTE:**

This repo has an OOP version satisfying "neoan3-provider/auth". If you want to use sessions in your neoan3 project, simply use Auth's SessionWrapper.