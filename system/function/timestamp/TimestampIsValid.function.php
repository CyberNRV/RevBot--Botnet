<?php
function TimestampIsValid($str = "")
{
    if(strtotime(date('d-m-Y H:i:s',$str)) === (int)$str) {
        return $str;
    } else return false;
}
?>