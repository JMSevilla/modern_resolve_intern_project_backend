<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface tokenizationInterface {
    public function routeUpdater($data);
}

class tokenRouteController extends DBHelper implements tokenizationInterface{
    public function routeUpdater($data){
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->tokenRouteUpdater("token/route/updater"))){
                $this->php_bind(":route", $data['route']);
                $this->php_bind(":uid", $data['id']);
                if($this->php_execute()) {
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "route_updated")]
                    );
                }
            }
        }
    }
}