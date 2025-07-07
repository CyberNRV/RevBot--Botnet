<?php
    class tpl{
        private $path;
        public function __construct()
        {
            global $lz_path;
            $this->path = $lz_path;
        }
        public function GetPage($page = ""){
            if(empty($page)){
                $page = "home";
                return $this->path["pages"]."/".$page.".php";
            }else{
                if(!file_exists($this->path["pages"]."/".$page.".php")){
                    $page = "404";
                }
                return $this->path["pages"]."/".$page.".php";
            }
        }
        public function GetPath(){
            return $this->path;
        }
    }


?>