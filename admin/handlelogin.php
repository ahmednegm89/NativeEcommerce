<?php
session_start();
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['user'];
    $userpass = $_POST['pass'];
    $hashedpass = md5($userpass);

    // check if user exist
    $sql = "SELECT UserID,Username , users.Password ,Email,FullName 
    FROM users 
    WHERE Username = '$username' 
    AND users.Password = '$hashedpass' 
    AND GroupID = 1 
    LIMIT 1  ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['adminname'] = $username;
        $_SESSION['userid'] = $row['UserID'];
        header("location:dashboard.php");
    } else {
        $_SESSION['loginerr'] = "Invaild user or pass";
        header("location:index.php");
    }
}
