<?php
session_start();
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $comment = $_POST['comment'];
    $itemid = $_POST['itemid'];
    $userid = $_POST['userid'];
    $errores = [];
    $vaild = true;
    if (empty($comment)) {
        $vaild = false;
    }
    if ($vaild === true) {
        // ADD IN DATABASE 
        $sql = "INSERT INTO comments(comments.Comment,comments.status,comments.comment_date,comments.item_id,comments.user_id) VALUES
        ('$comment',0,NOW(),'$itemid','$userid')
        ";
        $query = mysqli_query($conn, $sql);
        header("location:item.php?id=$itemid");
    } else {
        $_SESSION['commenterr'] = "can't be empty";
        header("location:item.php?id=$itemid");
    }
} else {
    header("location:index.php");
}
