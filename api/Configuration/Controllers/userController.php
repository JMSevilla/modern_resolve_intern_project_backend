<?php
include_once __DIR__ . "/db.php";
include_once __DIR__ . "/queries.php";
include_once __DIR__ . "/cookieManagement/cookie.php";
interface userInterface {
    public function checkUser($data);
    public function checkClient($data);
    public function clientRegistration($data);
    public function devRegistration($data);
    public function userLogin($data);
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

    public function checkClient($data)
    {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->checkClient("clients"))){
                $this->php_bind(":uname", $data['uname']);
                if($this->php_execute()){
                    if($this->php_row_checker()){
                        // exist
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "client_username_taken")]
                        );
                    }else{
                        // not exist
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "client_username_available")]
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
                $this->php_bind(":password", $this->php_password_encrypt($data['password']));
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

    public function clientRegistration($data) {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            if($this->php_prepare($query->postClient("post/client"))) {
                $this->php_bind(":clientfname", $data['clientfname']);
                $this->php_bind(":clientlname", $data['clientlname']);
                $this->php_bind(":clientemail", $data['clientemail']);
                $this->php_bind(":clientcontact",$data['clientcontact']);
                $this->php_bind(":clientaddress", $data['clientaddress']);
                $this->php_bind(":clientusername", $data['clientusername']);
                $this->php_bind(":clientpassword", $this->php_password_encrypt($data['clientpassword']));
                $this->php_bind(":clientsecquestion", $data['clientsecquestion']);
                $this->php_bind(":clientsecanswer", $data['clientsecanswer']);
                if($this->php_execute()){
                    echo $this->php_responses(
                        true,
                        "single",
                        (object)[0 => array("key" => "client_registration_success")]
                    ); 
                }
            }
        }
    }
    public function userLogin($data) {
        if($data['role'] === 'developer'){
            $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()) {
            if($this->php_prepare($query->postLogin("post/login"))) {
                $this->php_bind(":uname", $data['uname']);
                if($this->php_execute()){
                    if($this->php_row_checker()) {
                        $get = $this->php_fetch_row();
                        $pass = $get['password'];
                        $istype = $get['userType'];
                        $islock = $get['isLock'];
                        $uid = $get['id'];
                        $fname = $get['firstname'];
                        $lname = $get['lastname'];
                        $uname = $get['username'];
                        if($this->php_password_verify($data['pwd'], $pass)) {
                            if($islock === '1'){
                                //lock
                                echo $this->php_responses(
                                    true,
                                    "single",
                                    (object)[0 => array("key" => "ACCOUNT_LOCK")]
                                );
                            } else {
                                if($istype === '2') {
                                    //dev
                                    //token update
                                    //route to dev dashboard
                                    $INIT_TOKEN = new Tokenization();
                                    $INIT_TOKEN->checkAuthentication($uid, "developer_platform");
                                    $INIT_TOKEN->initFetchAuthentication($uid);
                                    $logged_array = [
                                        "fname" => $fname,
                                        "lname" => $lname,
                                        "uname" => $uname,
                                        "message" => "success_developer",
                                        "role" => "developer",
                                        "uid" => $uid
                                    ];
                                    echo $this->php_responses(
                                        true,
                                        "single",
                                        (object)[0 => array("key" => $logged_array)]
                                    );
                                }
                            }
                        } else { 
                            echo $this->php_responses(
                                true,
                                "single",
                                (object)[0 => array("key" => "PASSWORD_INVALID")]
                            ); 
                        }
                    }else {
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "ACCOUNT_NOT_FOUND")]
                        ); 
                    }
                }
            }
        }
        }
        else {
            ///client login
            echo $this->php_responses(
                true,
                "single",
                (object)[0 => array("key" => "CLIENT_ACCOUNT")]
            ); 
        }
    }
}

interface Authtoken { 
    public function setTokenState($istoken);
}

class Authentication extends DBHelper implements Authtoken {
    public function setTokenState($istoken = null) {
        DBParams::$tokenSetter = $istoken;
        return DBParams::$tokenSetter . $this->tokenGen();
    }
}

interface TokenizationConfig { 
    public function AuthenticationEntry($userID, $lastroute);
    public function checkAuthentication($userID, $lastroute);
    public function initFetchAuthentication($userID);
    public function tokenIdentify($userID);
}

class Tokenization extends DBHelper implements TokenizationConfig {
    public function AuthenticationEntry($userID, $lastroute) {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()){
            $Authentication = new Authentication();
            if($this->php_prepare($query->tokenEntry("tokenization/entry"))) {
                $this->php_bind(":id", $userID);
                $this->php_bind(":token", $Authentication->setTokenState("Basic:"));
                $this->php_bind(":lastroute", $lastroute);
                $this->php_bind(":isdestroyed", "0");
                $this->php_bind(":isvalid", "1");
                $this->php_execute();
            }
        }
    }
    public function checkAuthentication($userID, $lastroute) {
        $serverChecker = new Server();
        $query = new QueryHelper();
        if($serverChecker->POSTCHECKER()) {
            if($this->php_prepare($query->tokenValidation("tokenization/check/validation"))) {
                $this->php_bind(":uid", $userID);
                if($this->php_execute()) {
                    if($this->php_row_checker()) {
                        $get = $this->php_fetch_row();
                        if($get['isvalid'] === '1') { 
                            //update token
                        }
                        else {
                            $this->AuthenticationEntry($userID, $lastroute);
                        }
                    }else {
                        $this->AuthenticationEntry($userID, $lastroute);
                    }
                }
            }
        }
    }
    public function initFetchAuthentication($userID) { 
        $serverChecker = new Server();
        $query = new QueryHelper();
        $AuthenticationCookie = new AuthCookieManagement();
        if($serverChecker->POSTCHECKER()) {
            if($this->php_prepare($query->initFetchTokenization("tokenization/get"))) {
                $this->php_bind(":uid", $userID);
                if($this->php_execute()) {
                    if($this->php_row_checker()) {
                        $get = $this->php_fetch_row();
                        $AuthenticationCookie->authCookieSetter(
                            $get['token'],
                            time() + 60*60*24*7,
                            '/',
                            true,
                            true,
                            'None',
                            'admin_tokenization'
                        );
                    } else {
                        echo $this->php_responses(
                            true,
                            "single",
                            (object)[0 => array("key" => "account_disabled")]
                        );
                    }
                }
            }
        }
    }
    public function tokenIdentify($userID){
        if($userID === 'unknown') {
            echo $this->php_responses(
                true,
                "single",
                (object)[0 => array("key" => "invalid_token")]
            );
        } else { 
            $serverChecker = new Server();
            $query = new QueryHelper();
            if($serverChecker->POSTCHECKER()) {
                if($this->php_prepare($query->initCheckTokenization("tokenization/checking"))) {
                    $this->php_bind(":uid", $userID);
                    if($this->php_execute()) {
                        if($this->php_row_checker()) {
                            $fetch = $this->php_fetch_row();
                            if($fetch['isvalid'] === '1') {
                                if($fetch['lastRoute'] === 'developer_platform') {
                                    //get dev info profile
                                    if($this->php_prepare($query->get_current_user_info("user/getinformation"))){
                                        $this->php_bind(":uid", $userID);
                                        if($this->php_execute()){
                                            $getUserInfo = $this->php_fetch_row();
                                            $userArray = [
                                                'fname' => $getUserInfo['firstname'],
                                                'lname' => $getUserInfo['lastname'],
                                                'uname' => $getUserInfo['username'],
                                                'imgurl' => $getUserInfo['imgURL'],
                                                'key' => 'token_exist_dev_platform'
                                            ];
                                            echo $this->php_responses(
                                                true,
                                                "single",
                                                (object)[0 => array("key" => $userArray)]
                                            );
                                        }
                                    }
                                    
                                }
                            }
                        }else{
                            //invalid token
                            echo $this->php_responses(
                                true,
                                "single",
                                (object)[0 => array("key" => "invalid_token")]
                            );
                        }
                    }
                }
            }
        }
    }
}