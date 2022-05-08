<?php
include("./Configuration/Security/headers.php");
include_once "./Configuration/Controllers/tokenizationController.php";

if(isset($_POST['routeState']) === true ) {
    if($_POST['route'] === '/developer/dashboard') {
        $data = [
            'route' => $_POST['route'],
            'id' => $_POST['id']
        ];
    }
    $tokenRouteUpdater = new tokenRouteController();
    $tokenRouteUpdater->routeUpdater($data);
}