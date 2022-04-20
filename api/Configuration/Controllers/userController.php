<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface userInterface {
    public function checkUser($data);
    public function devRegistration($data);
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
    public function devRegistration($data) {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->postDev("post/dev"))) {
                $this->php_bind(":fname", $data['fname']);
                $this->php_bind(":lname", $data['lname']);
                $this->php_bind(":username", $data['username']);
                $this->php_bind(":password", $data['password']);
                $this->php_bind(":occupationStatus", $data['occupationStatus']);
                $this->php_bind(":occupationDetails", $data['occupationDetails']);
                $this->php_bind(":occupationPositionWork", $data['occupationPositionWork']);
                $this->php_bind(":nameOfSchool", $data['nameOfSchool']);
                $this->php_bind(":degree", $data['degree']);
                $this->php_bind(":address", $data['address']);
                if($this->php_execute()){
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "dev_registration_success")]
                    ); 
                }
            }
        }
    }
}