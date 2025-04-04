<?php
$str = 'wxyw w12w w@#w wwww abcw w123w';
preg_match_all('/w..w/', $str, $matches);
print_r($matches[0]);
?>