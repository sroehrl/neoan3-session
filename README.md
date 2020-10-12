# neoan3 basic session handling

This class handles basic PHP-session requirements and is designed to play nicely with a neoan3 setup.


## Installation
`composer require neoan3-apps/session`

## Implementation

Create a new Session as early as possible in your code with:

`new \Neoan3\Apps\Session();`

In a neoan3 installation, 

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

`Session::restrict($array||$string||null)`

Checks if user is logged in and (if parameter is set) whether the user belongs to 
- ONE OF the roles in the given array
- The role of the given string

and throws an exception is the condition is not met

`
