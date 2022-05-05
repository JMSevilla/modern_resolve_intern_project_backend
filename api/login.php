<?php
include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/userController.php";

if(isset($_POST['userLogin']) === true) {
    $data = [ 
        'uname' => $_POST['username'],
        'pwd' => $_POST['password'],
        'role' => $_POST['role']
    ];
    $callback = new userController();
    $callback->userLogin($data);
}