<?php

function lang($phrase)
{

    static $lang = [
        'MESSAGE' => 'Welcome',
        'ADMIN' => 'Administrator'
    ];
    return $lang[$phrase];
}
