<?php
function httpPost(string $url, array $data, int $delay = 500)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT_MS, $delay);
    $response = curl_exec($curl);
    $curl_errno = curl_errno($curl);
    curl_close($curl);
    if ($curl_errno > 0) {
        return "";
    } else {
        return $response;
    }



}
?>