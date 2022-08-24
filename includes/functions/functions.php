<?php

// title function

function gettitle()
{

    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    } else {
        echo 'DEFAULT';
    }
}


function clean($input)
{
    return htmlspecialchars(trim($input));
}
