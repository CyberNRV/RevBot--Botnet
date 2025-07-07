<?php
   function getCurrentFAI() {
       $ip = CurrIp();
       $host = @gethostbyaddr($ip); 
       $fai = false;
       if(substr_count($host, 'proxad')) $fai = 'free';
       if(substr_count($host, 'orange')) $fai = 'orange';
       if(substr_count($host, 'wanadoo')) $fai = 'orange';
       if(substr_count($host, 'sfr')) $fai = 'sfr';
       if(substr_count($host, 'club-internet')) $fai = 'sfr';
       if(substr_count($host, 'neuf')) $fai = 'neuf';
       if(substr_count($host, 'gaoland')) $fai = 'neuf';
       if(substr_count($host, 'bbox')) $fai = 'bouygues';
       if(substr_count($host, 'bouyg')) $fai = 'bouygues';
       if(substr_count($host, 'numericable')) $fai = 'numericable';
       if(substr_count($host, 'tele2')) $fai = 'tele2';
       if(!$fai){
           $fai = "null";
       }
       return $fai;
                    }
?>