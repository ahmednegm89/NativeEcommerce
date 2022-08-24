<?php
session_start();
$pagetitle = 'Log in';
include "init.php";

if (isset($_SESSION['username'])) {
    header("location:index.php");
}

if (isset($_SESSION['loginerr'])) {
    $loginerr = $_SESSION['loginerr'];
    unset($_SESSION['loginerr']);
}

?>


<div class="cont mt-5">
    <form class="login" action="handlelogin.php" method="POST">
        <h4> Login </h4>
        <div class="mb-3">
            <label for="usename" class="form-label">UserName</label>
            <input type="text" name="user" class="form-control" id="usename" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" id="Password">
        </div>
        <h4> <?php if (isset($loginerr)) {
                    echo $loginerr;
                } ?> </h4>
        <div>
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>
    </form>
</div>