<?php
session_start();
include "init.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // GET VALUES
    $user = clean($_POST['username']);
    $pass = clean($_POST['Password']);
    $email = clean($_POST['email']);
    $name = clean($_POST['fullname']);
    $hpass = md5($pass);
    $errores = [];
    $vaild = true;
    // vaildation
    $sql = "SELECT Username FROM users ";
    $query = mysqli_query($conn, $sql);
    $allusernames = [];
    while ($res = mysqli_fetch_row($query)) {
        $allusernames[] = $res[0];
    }
    if (in_array($user, $allusernames)) {
        $errores[] = "username already used";
        $vaild = false;
    }
    if (empty($user)) {
        $errores[] = "username cant be empty";
        $vaild = false;
    }
    if (strlen($user) < 4) {
        $errores[] = "username must be > 4";
        $vaild = false;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $pass)) {
        $errores[] = "pass must min 8 and contain number,capital letter and special character ";
        $vaild = false;
    }
    if (empty($email)) {
        $errores[] = "email cant be empty";
        $vaild = false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = " wrong email";
        $vaild = false;
    }
    if (empty($name)) {
        $errores[] = "fullname cant be empty";
        $vaild = false;
    }
    if ($vaild === true) {
        // ADD IN DATABASE 
        $sql = "INSERT INTO users(Username,users.Password,Email,FullName,RegStatus,users.Date) VALUES
        ('$user','$hpass','$email','$name',0,NOW())
        ";
        $query = mysqli_query($conn, $sql);
        echo "<h1 class='text-center mt-3 '>  Successfully signed </h1>";
        header("Refresh:2; url=login.php");
    } else {
        foreach ($errores as $error) {
            echo "<div  class='alert alert-danger container mt-5 ' role='alert'>
            $error
          </div>";
            header("Refresh:5; url=signup.php");
        }
    }
} else {
    echo '<h1 class="text-center mt-3 "> ERROR </h1>';
}
