<?php
interface ServerInterface
{
    public function POSTCHECKER();
}
interface Queryable {
    public function checkUser($args);
    public function postDev($args);
}
class QueryHelper implements Queryable{
    public function checkUser($args)
    {
        $sql = "select * from ".$args." where username=:uname";
        return $sql;
    }
    public function postDev($args) {
        if($args == "post/dev") {
            $sql = "CALL dev_proc(:fname, :lname, :username, :password,
            :occupationStatus, :occupationDetails, :occupationPositionWork, :nameOfSchool, :degree, :address
            )";
            return $sql;
        }
        
    }
}
class Server implements ServerInterface {
    public function POSTCHECKER()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }
}