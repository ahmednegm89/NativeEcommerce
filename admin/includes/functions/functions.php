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


function getcount($any, $tabel)
{
    global $conn;
    $sql2 = "SELECT COUNT($any) FROM $tabel";
    $query = mysqli_query($conn, $sql2);
    $res = mysqli_fetch_row($query);
    return $res[0];
}

function getpending($any, $tabel)
{
    global $conn;
    $sql3 = "SELECT COUNT($any) FROM $tabel WHERE RegStatus != 1 ";
    $query = mysqli_query($conn, $sql3);
    $res = mysqli_fetch_row($query);
    return $res[0];
}

function getlatest($select, $table, $order, $limit = 3)
{
    global $conn;
    $sql4 = "SELECT $select FROM $table WHERE GroupID != 1 ORDER BY $order DESC LIMIT $limit";
    $query = mysqli_query($conn, $sql4);
    $allres = [];
    while ($res = mysqli_fetch_assoc($query)) {
        $allres[] = $res;
    }
    return $allres;
}
function latestiems($select, $table, $order, $limit = 3)
{
    global $conn;
    $sql4 = "SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit";
    $query = mysqli_query($conn, $sql4);
    $allres = [];
    while ($res = mysqli_fetch_assoc($query)) {
        $allres[] = $res;
    }
    return $allres;
}
