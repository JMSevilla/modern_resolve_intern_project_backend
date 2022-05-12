<?php

include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/userController.php";



if(isset($_POST['regTrigger']) === true) {
    $data = [
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'occupationStatus' => $_POST['occupationStatus'],
        'occupationDetails' => $_POST['occupationDetails'],
        'occupationPositionWork' => $_POST['occupationPositionWork'],
        'nameOfSchool' => $_POST['nameOfSchool'],
        'degree' => $_POST['degree'],
        'address' => $_POST['address'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
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
        'clientsecanswer' => $_POST['clientsecanswer'],
        'clientsystemtype' => $_POST['clientsystemtype'],
        'clientrequestorstatus' => $_POST['clientrequestorstatus'],
        'clientprojectscale' => $_POST['clientprojectscale'],
        'clientbudgetrange' => $_POST['clientbudgetrange'],
        'clientremarks' => $_POST['clientremarks'],
        'clientpayment' => $_POST['clientpayment']
    ];
    $callback = new userController();
    $callback->clientRegistration($data);
}



