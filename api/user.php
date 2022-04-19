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

if(isset($_POST['regTrigger']) === true) {
    $data = [
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'occupationStatus' => $_POST['occupationStatus'],
        'occupationDetails' => $_POST['occupationDetails'],
        'occupationPositionWork' => $_POST['occupationPositionWork'],
        'nameofSchool' => $_POST['nameOfSchool'],
        'degree' => $_POST['degree'],
        'address' => $_POST['address'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];
    $callback = new userController();
    $callback->devRegistration($data);
}