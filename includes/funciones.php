


<?php


function debug($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    
}


function s($variable): string
{

    $s = strip_tags($variable);
    return $s;
}
