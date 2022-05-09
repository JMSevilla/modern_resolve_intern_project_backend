<?php

include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/usermanagementController.php";

if(isset($_POST['userMState']) === true) {
    $data = [
        'fname' => $_POST['firstname'],
        'lname' => $_POST['lastname'],
        'uname' => $_POST['username'],
        'branch' => $_POST['branch'],
        'password' => $_POST['password'],
        'branchStatus' => $_POST['branchStatus'],
    ];
    $UAM = new UsermanagementController();
    $UAM->UAMCheck($data);
}