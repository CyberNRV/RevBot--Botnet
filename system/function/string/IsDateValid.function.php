<?php
function isDateValid($dateString) {
    $format = 'd/m/Y';
    $date = DateTime::createFromFormat($format, $dateString);

    return $date && $date->format($format) === $dateString;
}
?>