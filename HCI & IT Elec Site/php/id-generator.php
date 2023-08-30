<?php

include('db-connect.php');

function random_num($length)
{
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0,9);
    }

    return $result;
    
}


?>