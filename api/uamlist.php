<?php
include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/uamlistController.php";

if(isset($_POST['uamlistState']) === true) {
    $uamlist = new UAMController();
    $uamlist->listofusers();
}