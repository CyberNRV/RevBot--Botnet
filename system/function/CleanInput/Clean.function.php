<?php
//POWER BY CyberNrv
function CleanInput($input) {
  if (is_array($input) or empty($input)){
      return "";
  }
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    $output = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $output);
    // ----- remove HTML TAGs ----- 
    $output = preg_replace ('/<[^>]*>/', ' ', $output); 
    // ----- remove control characters ----- 
    $output = str_replace("\r", '', $output);
    $output = str_replace("\n", ' ', $output);
    $output = str_replace("\t", ' ', $output);
    // ----- remove multiple spaces ----- 
    return $output;
  }
?>
