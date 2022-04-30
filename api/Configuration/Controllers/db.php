<?php

class DBParams {
    public static $host = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $db = "dbmodern";
    public static $stmt;
    public static $helper;
    public static $tokenSetter;
}

class DBHelper {
    public function connect() {
        try {
            $conString = "mysql:host=" . DBParams::$host . ";dbname=" . DBParams::$db;
            DBParams::$helper = new PDO($conString, DBParams::$username, DBParams::$password);
            DBParams::$helper->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return DBParams::$helper;
        } catch (PDOException $th) {
            die("Could not connect" . $th->getMessage());
        }
    }
    public function php_prepare($sql) {
        return DBParams::$stmt = $this->connect()->prepare($sql);
    }
    public function php_bind($param, $val, $type = null) {
        if(is_null($type)){
            switch(true){
                case $type == 1:
                    $type = PDO::PARAM_INT;
                    break;
                case $type == 2:
                    $type = PDO::PARAM_BOOL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        return DBParams::$stmt->bindParam($param, $val, $type);
    }
    public function php_execute(){
        return DBParams::$stmt->execute();
    }
    public function php_responses(
        $bool,
        $payload = null,
        $isArray
    ) {
        switch ($bool) {
            case $payload == "single":
                return json_encode($isArray, JSON_FORCE_OBJECT);
                break;
            case $payload == "normal":
                return json_encode($isArray);
                break;
        }
    }
    public function php_row_checker(){
        return DBParams::$stmt->rowCount() > 0;
    }
    public function php_fetch_row(){ 
        return DBParams::$stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function php_password_verify($request, $getPassword) {
        return password_verify($request, $getPassword);
    }
    public function tokenGen()
    {
        return bin2hex(random_bytes(16));
    }
}