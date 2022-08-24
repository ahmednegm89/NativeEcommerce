<?php

if (!$conn = mysqli_connect("localhost", "root", "", "shop")) {
    die("failed to conn :" . mysqli_connect_error());
}
