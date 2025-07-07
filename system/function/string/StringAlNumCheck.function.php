<?php
function StringAlNumCheck($str, $more_chars = '') {
  # check type
  if (!is_string($str)) return false;

  # handle allowed chars
  if (mb_strlen($more_chars) > 0) {
    # don't allow ^, ] and \ in allowed chars
    $more_chars = str_replace(array('^', ']', '\\'), '', $more_chars);

    # escape dash
    $escaped_chars = strpos($more_chars, '-') !== false
      ? str_replace('-', '\-', $more_chars)
      : $more_chars;

    # allowed chars must be non-consecutive
    for ($i=0; $i < mb_strlen($more_chars); $i++) {
      $consecutive_test = preg_match('/[' . $more_chars[$i] . '][' . $escaped_chars . ']/', $str);
      if ($consecutive_test === 1) return false;
    }

    # allowed chars shouldn't be at the start and the end of the string
    if (strpos($more_chars, $str[0]) !== false) return false;
    if (strpos($more_chars, $str[mb_strlen($str) - 1])) return false;
  }
  else $escaped_chars = $more_chars;

  $result = preg_match('/^[a-zA-Z0-9' . $escaped_chars . ']{4,}$/', $str);

  return $result === 1 ? true : false;
}
?>