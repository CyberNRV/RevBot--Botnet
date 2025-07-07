<?php
class user
{
    private $db;
    private $table = "users";
    public function __construct()
    {
        global $db;
        $this->db = $db;
    }
    //*GetData
    public function GetData($token = "")
    {
        if ($this->CheckToken($token)) {
            return GetDataArray($this->table, "TOKEN", $token);
        }
        return array();
    }
    //*CheckSession
    public function CheckLogin()
    {
        if (isset($_SESSION['TOKEN'])) {
            if ($this->CheckToken($_SESSION['TOKEN'])) {
                if (!$this->IsBan($_SESSION['TOKEN'])) {
                    return true;
                }
            }
        }
        return false;
    }
    public function IsAdmin($token = "")
    {
        if (empty($token)) {
            return false;
        }
        if ($this->CheckToken($token)) {
            if ($this->GetData($token)['RANK'] == "1") {
                return true;
            }
        }
        return false;
    }
    public function IsBan($token = "")
    {
        if (isset($token)) {
            if (Checker1($this->table, "TOKEN", $token)) {
             
                if (Checker2($this->table, "TOKEN","STATUS", $token, "0")) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return true;
    }
    //*Token
    public function CheckToken($token = "")
    {
        if ($token == "") {
            return false;
        }
        $token = CleanInput($token);
        if (Checker1($this->table, "TOKEN", $token)) {
            return true;
        }
        return false;
    }
    public function GenerateToken()
    {
        $token = GenerateToken("USER_");
        while ($this->CheckToken($token)) {
            $token = GenerateToken("USER_");
        }
        return $token;
    }

    //*Credential
    //*Register
    public function Register($param = array(), $echo = true)
    {
        //*return value
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();


        @$token = $this->GenerateToken();
        @$username = CleanInput(StringLower($param['username']));
        @$password = $param['password'];
        @$password_confirm = $param['password_confirm'];

        $last_ip = CurrIp();
        $finger = GenFinger();
        $status = "1";
        $rank = "0";
        $last_login = time();
        $register = time();

        //*Check Username
        if (empty($username)) {
            $return['error'][] = "Username is empty";
        } else {
            if (Checker1($this->table, "USERNAME", $username)) {
                $return['error'][] = "Username already exist";
            } else {
                if (strlen($username) < 4) {
                    $return['error'][] = "Username is too short";
                } else {
                    if (strlen($username) > 20) {
                        $return['error'][] = "Username is too long";
                    } else {
                        if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                            $return['error'][] = "Username is invalid";
                        } else {
                            //$return['success'][] = "Username is valid";
                        }
                    }
                }
            }
            //*Check Password
            if (empty($password)) {
                $return['error'][] = "Password is empty";
            } else {
                if (strlen($password) < 6) {
                    $return['error'][] = "Password is too short";
                } else {
                    if (strlen($password) > 20) {
                        $return['error'][] = "Password is too long";
                    } else {
                        if ($password != $password_confirm) {
                            $return['error'][] = "Password is not match";
                        } else {
                            if (CheckPasswordStrength($password) == false) {
                                $return['error'][] = "Password is weak";
                            } else {
                                $passcrypt = new passcrypt();
                                $finalpassword = $passcrypt->Protect($password);
                            }
                        }
                    }
                }
            }
        }
        if (empty($return['error'])) {
            $SqlData = array();
            $SqlData[':TOKEN'] = $token;
            $SqlData[':USERNAME'] = $username;
            $SqlData[':PASSWORD'] = $finalpassword;
            $SqlData[':LASTIP'] = $last_ip;
            $SqlData[':FINGERPRINT'] = $finger;
            $SqlData[':STATUS'] =  $status;
            $SqlData[':RANK'] = $rank;
            $SqlData[':LASTLOGIN'] = $last_login;
            $SqlData[':REGISTER'] =     $register;
            $SqlData[':MONEY'] =     "0";

            $iDATA = $this->db->prepare("INSERT INTO `$this->table` VALUES(NULL,:TOKEN,:USERNAME,:PASSWORD,:LASTIP,:FINGERPRINT,:STATUS,:RANK,:LASTLOGIN,:REGISTER,:MONEY)");
            $iDATA->execute($SqlData);

            $return['success'][] = "User has been registered";
        }

        global $msg;

        $msg->ShowArray($return);

        return $return;
    }

    public function Login($param = array(), $echo = true)
    {
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();
        //*CleanInput
        @$username = CleanInput(StringLower($param['username']));
        @$password = $param['password'];

        //*Check Username
        if (empty($username)) {
            $return['error'][] = "Username is empty";
        } else {
            if (!Checker1($this->table, "USERNAME", $username)) {
                $return['error'][] = "Username or password invalid";
            } else {
                $curr_data = GetDataArray($this->table, "USERNAME", $username);
                $passcrypt = new passcrypt();
                if ($passcrypt->Check($curr_data['PASSWORD'],$password)) {
                    $return['success'][] = "Connexion success";
                    $_SESSION['TOKEN'] = $curr_data['TOKEN'];
                  
                } else {
                    $return['error'][] = "Username or password is invalid";
                }
            }


            global $msg;
            $msg->ShowArray($return);
            return $return;
        }
    }
    public function UpdatePassword($param = array(),$echo = true){
        //*return
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();

    
        $param['token'] = CleanInput($param['token']);
        $param['password'] = $param['password'];
        $param['password_confirm'] = $param['password_confirm'];

        if($this->CheckToken($param['token'])){
            if(empty($param['password'])){
                $return['error'][] = "Password is empty";
            }else{
                if(strlen($param['password']) < 6){
                    $return['error'][] = "Password is too short";
                }else{
                    if(strlen($param['password']) > 20){
                        $return['error'][] = "Password is too long";
                    }else{
                        if($param['password'] != $param['password_confirm']){
                            $return['error'][] = "Password is not match";
                        }else{
                            if(CheckPasswordStrength($param['password']) == false){
                                $return['error'][] = "Password is weak";
                            }else{
                                $passcrypt = new passcrypt();
                                $finalpassword = $passcrypt->Protect($param['password']);
                                SqlUpdater1($this->table,"PASSWORD",$finalpassword,"TOKEN",$param['token']);
                                $return['success'][] = "Password has been updated";
                            }
                        }
                    }
                }
            }
        }else{
            $return['error'][] = "Token is invalid";
        }
        global $msg;
        $msg->ShowArray($return,$echo);
        return $return;
    }
}
