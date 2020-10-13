<?php

// initialize sessions before any headers
$oop = new \Neoan3\Apps\SessionOOP();
// this starts the session with a prefix (required in OOP context)
$oop->setSecret('any-');

try{
    $user = $oop->restrict();
} catch (Exception $e){
    echo "The user is not authenticated";
}

// Authenticate a user (e.g. after login)
$assigned = $oop->assign('userID-abc', ['read']);

// This time restrict() successfully returns a session Auth object
// see SessionAuthObjectCopy as a reference
$user = $oop->restrict();


