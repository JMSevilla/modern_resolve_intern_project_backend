<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface userInterface {
    public function checkUser($data);
}

class userController extends DBHelper implements userInterface {
    public function checkUser($data)
    {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->checkUser("users"))){
                $this->php_bind(":uname", $data['uname']);
                if($this->php_execute()){
                    if($this->php_row_checker()){
                        // exist
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "username_taken")]
                        );
                    }else{
                        // not exist
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "username_available")]
                        );
                    }
                }
            }
        }
    }
}