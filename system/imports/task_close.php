
<?php
$curr_group = $group->GetData($_GET['group']);
    if(isset($_POST['AddTask'])){
        if($_POST['p'] == "add_task"){
            if($_GET['type'] == "close"){
                $param = array();
                $param['USER_TOKEN'] = $curr_user['TOKEN'];

                $param['EXPIRE'] = $_POST['expiredate'];
                $param['TYPE'] = $_GET['type'];
                $param['GROUP_TOKEN'] = $curr_group['TOKEN'];
                if(isset($_POST['runonce'])){
                    $param['RUN_ONCE'] = "true";
                }else{
                    $param['RUN_ONCE'] = "false";
                }
                if(isset($_POST['status'])){
                    $param['STATUS'] = "true";
                }else{
                    $param['STATUS'] = "false";
                }
                
     
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
</div>
</div>

<hr>