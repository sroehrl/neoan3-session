# neoan3 basic session handling

This class handles basic PHP-session requirements and is designed to play nicely with a neoan3 setup.


## Installation
`composer require neoan3-apps/db`

## Usage

`Session::login($userId)`

Registers a user with the following template

```PHP
[
    'user'       => ['id' => $user_id, 'user_type' => 'user'],
    'roles'      => [],
    'user_email' => ['confirm_date' => null]
];
```

`Session::logout()`

Terminates all session variables

`Session::add_session($array)`

Adds multiple variables using an associative array.

`Session::restricted($array||$string||void)`

Checks if user is logged in and (if parameter is set) whether the user belongs to 
- ONE OF the roles in the given array
- The role of the given string

and redirects to the default page (home?) if condition is not met.

`Session::api_restricted($array||$string||void)`

Same as restricted, but echoes the JSON
```JSON
{"error":"permission_denied"}
```
and ends execution.
