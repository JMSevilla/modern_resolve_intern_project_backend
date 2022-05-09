<?php

include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";

interface usermanagementInterface {
    public function postCreate($data);
    public function UAMCheck($data);
}

class UsermanagementController extends DBHelper implements usermanagementInterface {
    public function postCreate($data)
    {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()) {
            if($this->php_prepare($query->postcreatedevUAM('uam/post'))) {
                $this->php_bind(':fname', $data['fname']);
                $this->php_bind(':lname', $data['lname']);
                $this->php_bind(':uname', $data['uname']);
                $this->php_bind(':pwd', $this->php_password_encrypt($data['password'], PASSWORD_DEFAULT));
                $this->php_bind(':utype', $data['branch']);
                $this->php_bind(':islock', $data['branchStatus']);
                if($this->php_execute()){
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "success_uam_create")]
                    );
                }
            }
        }
    }
    public function UAMCheck($data){
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->uamcheck('uam/check'))) {
                $this->php_bind(':uname', $data['uname']);
                if($this->php_execute()){
                    if($this->php_row_checker()){
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "username_exist")]
                        );
                    }
                    else{
                        $this->postCreate($data);
                    }
                }
            }
        }
    }
}