<?php
include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/userController.php";

if(isset($_POST['tokenstate']) === true) 
{
    $tokenization = new Tokenization();
    $tokenization->tokenIdentify($_POST['token']);
}

