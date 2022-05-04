<?php
interface ServerInterface
{
    public function POSTCHECKER();
}
interface Queryable {
    public function checkUser($args);
    public function checkClient($args);
    public function postDev($args);
    public function postClient($args);
    public function postLogin($payload);
    public function tokenCheck($payload);
    public function tokenEntry($payload);
    public function tokenValidation($payload);
    public function initFetchTokenization($payload);
    public function initCheckTokenization($payload);
    public function get_current_user_info($payload);
}
class QueryHelper implements Queryable{
    public function checkUser($args)
    {
        $sql = "select * from ".$args." where username=:uname";
        return $sql;
    }
    public function checkClient($args)
    {
        $sql = "select * from ".$args." where username=:uname";
        return $sql;
    }
    public function postDev($args) {
        if($args == "post/dev") {
            $sql = "CALL dev_proc(:fname, :lname, :username, :password,
            :occupationStatus, :occupationDetails, :occupationPositionWork, :nameOfSchool, :degree, :address)";
            return $sql;
        }
        
    }
    public function postClient($args) {
        if($args == "post/client") {
            $sql = "CALL client_proc(:clientfname, :clientlname, :clientemail, :clientcontact,
            :clientaddress, :clientusername, :clientpassword, :clientsecquestion, :clientsecanswer
            )";
            return $sql;
        }
        
    }
    public function postLogin($payload) {
        if($payload == "post/login") {
            $sql = "select * from users where username=:uname";
            return $sql;
        }
    }
    public function tokenCheck($payload){
        if($payload === 'tokenization/check') {
            $sql = "select token from tokenization where userID=:id and isDestroyed='0'";
            return $sql;
        }
    }
    public function tokenEntry($payload){
        if($payload === 'tokenization/entry') {
            $sql = "insert into tokenization values(default, :id, :token, :lastroute, :isdestroyed, current_timestamp, :isvalid)";
            return $sql;
        }
    }
    public function tokenValidation($payload) {
        if($payload === 'tokenization/check/validation') {
            $sql = "select * from tokenization where userID=:uid";
            return $sql;
        }
    }
    public function initFetchTokenization($payload) 
    {
        if($payload === 'tokenization/get') {
            $sql = "select * from tokenization where userID=:uid";
            return $sql;
        }
    }
    public function initCheckTokenization($payload) {
        if($payload === 'tokenization/checking') {
            $sql = "select * from tokenization where userID=:uid and isvalid='1'";
            return $sql;
        }
    }
    public function get_current_user_info($payload){
        if($payload === 'user/getinformation') {
            $sql = "select * from users where id=:uid";
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