<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface UAMInterface { 
    public function listofusers();
}

class UAMController extends DBHelper implements UAMInterface {
    public function listofusers(){
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()) {
            if($this->php_query($query->listuam('uam/list'))) {
                if($this->php_execute()) {
                    $fetch = $this->php_fetch_all();
                    echo json_encode($fetch);
                }
            }
        }
    }
}