<?php

include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/userController.php";

if(isset($_POST['userTrigger']) === true) {
    $data = [
        'uname' => $_POST['username']
    ];
    $callback = new userController();
    $callback->checkUser($data);
}

if(isset($_POST['clientTrigger']) === true) {
    $data = [
        'uname' => $_POST['clientusername']
    ];
    $callback = new userController();
    $callback->checkClient($data);
}

if(isset($_POST['regTrigger']) === true) {
    $data = [
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'occupationStatus' => $_POST['occupationStatus'],
        'occupationDetails' => $_POST['occupationDetails'],
        'occupationPositionWork' => $_POST['occupationPositionWork'],
        'nameOfSchool' => $_POST['nameOfSchool'],
        'degree' => $_POST['degree'],
        'address' => $_POST['address']

    ];
    $callback = new userController();
    $callback->devRegistration($data);
}

if(isset($_POST['clientRegTrigger']) === true) {
    $data = [
        'clientfname' => $_POST['clientfname'],
        'clientlname' => $_POST['clientlname'],
        'clientemail' => $_POST['clientemail'],
        'clientcontact' => $_POST['clientcontact'],
        'clientaddress' => $_POST['clientaddress'],
        'clientusername' => $_POST['clientusername'],
        'clientpassword' => $_POST['clientpassword'],
        'clientsecquestion' => $_POST['clientsecquestion'],
        'clientsecanswer' => $_POST['clientsecanswer']
    ];
    $callback = new userController();
    $callback->clientRegistration($data);
}


if(isset($_POST['userLogin']) === true) {
    $data = [ 
        'uname' => $_POST['username'],
        'pwd' => $_POST['password'],
        'role' => $_POST['role']
    ];
    $callback = new userController();
    $callback->userLogin($data);
}

if(isset($_POST['tokenstate']) === true) 
{
    $tokenization = new Tokenization();
    $tokenization->tokenIdentify($_POST['token']);
}