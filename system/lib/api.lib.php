<?php
class api
{
    private $db;
    private $table = "api_key";

    public function __construct()
    {
        global $db;
        $this->db = $db;
        return true;
    }

    public function CheckKey($key)
    {
        $key = CleanInput($key);
        if (Checker1($this->table, "API_KEY", $key)) {
            return true;
        } else {
            return false;
        }
    }
    public function Request($param = array())
    {
        $return = array();
        $return['success'] = array();
        $return['error'] = array();
        $return['info'] = array();
        $return['warning'] = array();


        $param['API_KEY'] = CleanInput($param['API_KEY']);
        $param['HWID'] = CleanInput($param['HWID']);
        $param['HOST'] = CurrIp();
        if (empty($param['API_KEY'])) {
            $return['e rror'][] = "API_KEY is required";
        } else {
            if (!$this->CheckKey($param['API_KEY'])) {
                $return['error'][] = "API_KEY is invalid";
            } else {
                $xxx = GetDataArray($this->table, "API_KEY", $param['API_KEY']);
                $xxx = $xxx['REQUEST'] + 1;
                SqlUpdater1($this->table, "API_KEY", $param['API_KEY'], "REQUEST", $xxx);
            }
        }
        if (empty($return['error'])) {
            global $bots;
            $data = $bots->Request($param);
            $return['request'] = $data;
            return json_encode( $return);
        } else {
            return json_encode( $return);
        }
    }

    
}
