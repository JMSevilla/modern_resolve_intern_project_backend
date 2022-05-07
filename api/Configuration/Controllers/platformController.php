<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface platformInterface { 
    public function GET_Listplatforms();
}

class platformController extends DBHelper implements platformInterface {
    public function GET_Listplatforms() {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_query($query->getplatforms("platforms/get"))){
                if($this->php_execute()){
                    $willConverttoJSON = $this->php_fetch_all();
                    echo json_encode($willConverttoJSON);
                }
            }
        }
    }
}