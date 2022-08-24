<?php
session_start();
$pagetitle = 'sign up';
include "init.php";
?>
<div class="container mt-5">
    <form class="d-flex flex-column" action="hsignup.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Password</label>
            <input type="Password" name="Password" class="form-control" id="pass" placeholder="pass must min 8 and contain number,capital letter and special character" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="" required>
        </div>
        <div class="mb-3">
            <label for="full" class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" id="full" placeholder="" required>
        </div>
        <button type="submit" class="btn btn-success w-25 mx-auto"> sign up </button>
    </form>
</div>