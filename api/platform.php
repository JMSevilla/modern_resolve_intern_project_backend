<?php

include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/platformController.php";

if(isset($_POST['platformState']) === true) {
    $platforms = new platformController();
    $platforms->GET_Listplatforms();
}
