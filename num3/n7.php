<?php

function printStringReturnNumber()
{
    echo "Это строка, которую печатает функция.\n";
    return 42; 
}

$my_num = printStringReturnNumber();

echo "Возвращенное число: $my_num\n";