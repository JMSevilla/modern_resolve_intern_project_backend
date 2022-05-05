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