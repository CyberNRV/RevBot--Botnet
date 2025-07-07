<?php
class group
{
    //* 	ID 	TOKEN 	USER_TOKEN 	NAME 	STATUS 	
    private $table = "groups";
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    } 
    public function CheckGroupWhereUser($token, $user_token)
    {
        $token = CleanInput($token);
        $user_token = CleanInput($user_token);
        if (Checker2($this->table, "TOKEN", "USER_TOKEN", $token, $user_token)) {
            return true;
        }
    }
    public function CheckToken($token)
    {
        $token = CleanInput($token);
        if (Checker1($this->table, "TOKEN", $token)) {
            return true;
        }
        return false;
    }
    public function GenerateToken()
    {
        $token = GenerateToken("GROUP_");
        while ($this->CheckToken($token)) {
            $token = GenerateToken("GROUP_");
        }
        return $token;
    }
    public function Add($param = array(), $echo = true)
    {
        //*Protect param
        $param['NAME'] = CleanInput(StringLower($param['NAME']));
        $param['STATUS'] = CleanInput($param['STATUS']);
        //*return value
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();

        //*Check User
        global $user;
        if ($user->CheckLogin()) {
            $curr_data = $user->GetData($_SESSION['TOKEN']);
        } else {
            $return['error'][] = "You are not logged in";
        }
        if (empty($return['error'])) {
            if (empty($param['NAME'])) {
                $return['error'][] = "Name is required";
            } else {
                if (Checker2($this->table, "NAME", "USER_TOKEN", $param['NAME'], $curr_data['TOKEN'])) {
                    $return['error'][] = "Name is already exists";
                }
            }
            if (empty($param['STATUS'])) {
                $return['error'][] = "Status is required";
            } else {
                if ($param['STATUS'] == "false") {
                    $final_status = "0";
                } else {
                    if ($param['STATUS'] == "true") {
                        $final_status = "1";
                    } else {
                        $return['error'][] = "Status is invalid";
                    }
                }
            }
        }
        if (empty($return['error'])) {
            $SqlData[':TOKEN'] = $this->GenerateToken();
            $SqlData[':USER_TOKEN'] =     $curr_data['TOKEN'];
            $SqlData[':NAME']       =     $param['NAME'];
            $SqlData[':STATUS']     =     $final_status;
            $iDATA = $this->db->prepare("INSERT INTO `$this->table` VALUES(NULL,:TOKEN,:USER_TOKEN,:NAME,:STATUS)");
            $iDATA->execute($SqlData);
            $return['success'][] = "Group added";
        }
        global $msg;
        $msg->ShowArray($return, $echo);
        return $return;
    }
    public function Edit($param = array(), $echo = true)
    {
        //*return value
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();
        //*Protect param
        $param['TOKEN'] = CleanInput($param['TOKEN']);
        $param['NAME'] = CleanInput(StringLower($param['NAME']));
        $param['STATUS'] = CleanInput($param['STATUS']);
        //*Check User
        global $user;
        if ($user->CheckLogin()) {
            $curr_user = $user->GetData($_SESSION['TOKEN']);
            $curr_data = $this->GetData($param['TOKEN']);
            if (Checker2($this->table, "TOKEN", "USER_TOKEN", $param['TOKEN'], $curr_user['TOKEN'])) {
                if (empty($param['NAME'])) {
                    $return['error'][] = "Name is required";
                } else {
                    if (Checker2($this->table, "NAME", "USER_TOKEN", $param['NAME'], $curr_data['TOKEN'])) {
                        $return['error'][] = "Name is already exists";
                    } else {
                        if ($param['NAME'] != $curr_data['NAME']) {
                            SqlUpdater1($this->table, "NAME", $param['NAME'], "TOKEN", $param['TOKEN']);
                            $return['success'][] = "Name updated";
                        } else {
                            $return['info'][] = "Name is same";
                        }
                    }
                }
                if (empty($param['STATUS'])) {
                    $return['error'][] = "Status is required";
                } else {
                    if ($param['STATUS'] == "false") {
                        $final_status = "0";
                    } else {
                        if ($param['STATUS'] == "true") {
                            $final_status = "1";
                        }
                    }
                    if ($final_status != $curr_data['STATUS']) {
                        SqlUpdater1($this->table, "STATUS", $final_status, "TOKEN", $param['TOKEN']);
                        $return['success'][] = "Status updated";
                    } else {
                        $return['info'][] = "Status is same";
                    }
                }
            }
        } else {
            $return['error'][] = "You are not logged in";
        }
        global $msg;
        $msg->ShowArray($return, $echo);
        return $return;
    }
    public function Delete($token, $echo = true)
    {
        $token = CleanInput($token);
        //*return value
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();
        //*Check User
        global $user;
        if ($user->CheckLogin()) {
            $curr_data = $user->GetData($_SESSION['TOKEN']);
            if (Checker2($this->table, "TOKEN", "USER_TOKEN", $token, $curr_data['TOKEN'])) {
                $dDATA = $this->db->prepare("DELETE FROM `$this->table` WHERE TOKEN=:TOKEN");
                $dDATA->bindParam(":TOKEN", $token);
                $dDATA->execute();
                $return['success'][] = "Group deleted";
            } else {
                $return['error'][] = "Group not found";
            }
        } else {
            $return['error'][] = "You are not logged in";
        }
        global $msg;
        $msg->ShowArray($return, $echo);
        return $return;
    }
    public function GetGroupArray($user_token)
    {
        $user_token = CleanInput($user_token);
        global $user;
        if ($user->CheckToken($user_token)) {
            return GetDataArrayTableWhere1arg($this->table, "USER_TOKEN", $user_token);
        } else {
            return array();
        }
        return array();
    }
    public function GetData($token)
    {
        $token = CleanInput($token);
        if($this->CheckToken($token)){
            return GetDataArray($this->table, "TOKEN", $token);
        }
        return array();
    }
}
