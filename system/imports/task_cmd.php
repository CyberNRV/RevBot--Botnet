<?php
$curr_group = $group->GetData($_GET['group']);
if (isset($_POST['AddTask'])) {
    if ($_POST['p'] == "add_task") {
        if ($_GET['type'] == "cmd") {
            $param = array();
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
            $param['ARG_ARRAY']["COMMAND"] = @$_POST['cmd'];
            $param['ARG_ARRAY']["ACCESS"] = @$_POST['access'];

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
<h6>command</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <textarea type="text" name="cmd" class="form-control" placeholder="cmd" value="">  </textarea>
</div>
<br>
<h6>Access</h6>
<div class="input-group">
    <span class="input-group-text"><i class="fa-light fa-info"></i></span>
    <select class="form-select" name="access" aria-label="access">
        <option value="user">User</option>
        <option value="admin">admin</option>
        <option value="force">force</option>

    </select>
</div>
    <br>



<hr>