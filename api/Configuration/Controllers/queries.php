<?php
interface ServerInterface
{
    public function POSTCHECKER();
}
interface Queryable {
    public function checkUser($args);
}
class QueryHelper implements Queryable{
    public function checkUser($args)
    {
        $sql = "select * from ".$args." where username=:uname";
        return $sql;
    }
}
class Server implements ServerInterface {
    public function POSTCHECKER()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }
}