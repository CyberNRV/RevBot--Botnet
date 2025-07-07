<?php
function GetCountry($ip)
{
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if ($ip_data && $ip_data->geoplugin_countryName != null) {
        $result = $ip_data->geoplugin_countryName;
    } else {
        $result = "Unknown";
    }
    return $result;
}
?>