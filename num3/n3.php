<?php

$numLanguages = 4; // Ruby, Python, JavaScript, C++
$months = 11;

$days = $months * 16;
$daysPerLanguage = $days / $numLanguages;
echo "Среднее количество дней на изучение одного языка: " . $daysPerLanguage;