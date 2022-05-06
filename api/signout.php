<?php
include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/userController.php";


if(isset($_POST['signoutState']) === true) {
    $tokenization = new Tokenization();
    $tokenization->signoutDestroy($_POST['userid']);
}