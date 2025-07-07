<?php
    class msgbox{
        private $success = '<label class="col-12">
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert success">
          <span class="alertClose">X</span>
          <span class="alertText">{DATA}
              <br class="clear"/></span>
        </div>' ;
        private $error = '<label class="col-12">
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">{DATA}
              <br class="clear"/></span>
        </div>' ;
        private $warning = '<label class="col-12">
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert warning">
          <span class="alertClose">X</span>
          <span class="alertText">{DATA}
              <br class="clear"/></span>
        </div>' ;
        private $info = '<label class="col-12">
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert info">
          <span class="alertClose">X</span>
          <span class="alertText">{DATA}
              <br class="clear"/></span>
        </div>' ;

        public function __construct(){
            
        }
        public function Show($msg, $type,$echo = true){
            if($type == "success"){
                $msg2 = str_replace("{DATA}",$msg,$this->success);
            }elseif($type == "error"){
                $msg2 = str_replace("{DATA}",$msg,$this->error);
            }elseif($type == "warning"){
                $msg2 = str_replace("{DATA}",$msg,$this->warning);
            }elseif($type == "info"){
                $msg2 = str_replace("{DATA}",$msg,$this->info);
            }
            if($echo){
                echo $msg2;
            }
            return $msg;
        }
        public function ShowArray($araay = array(), $echo = true){
            $msg = "";
            foreach($araay['success'] as $value){
                $msg .= $this->Show($value,"success",$echo);
            }
            foreach($araay['error'] as $value){
                $msg .= $this->Show($value,"error",$echo);
            }
            foreach($araay['info'] as $value){
                $msg .= $this->Show($value,"info",$echo);
            }
            foreach($araay['warning'] as $value){
                $msg .= $this->Show($value,"warning",$echo);
            }
        
            return $araay;
        }
    }
?>