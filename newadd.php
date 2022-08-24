<?php
session_start();
$pagetitle = 'ADD AD';
include "init.php";
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
if (isset($_SESSION['userid'])) {
    $id = $_SESSION['userid'];
}
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'add') { ?>
    <h1 class="text-center mt-3 "> Add item </h1>
    <!-- ADD form -->
    <div class="container">
        <form class="d-flex flex-column" action="?action=insert" method="POST">
            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="Description" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="Price" class="form-label">Price</label>
                <input type="text" name="price" class="form-control" id="Price" aria-describedby="emailHelp" value="$">
            </div>
            <div class="mb-3">
                <label for="Country_Made" class="form-label">Made in ...</label>
                <input type="text" name="country" class="form-control" id="Country_Made" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="Status" class="form-label">Condition</label>
                <select class="form-select" aria-label="Default select example" id="Status" name="status">
                    <option value="0"> .... </option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="categories" class="form-label">categories</label>
                <select class="form-select" aria-label="Default select example" id="categories" name="cat">
                    <option value="0"> .... </option>
                    <?php
                    $sql = "SELECT * FROM categories ";
                    $query = mysqli_query($conn, $sql);
                    $allcats = [];
                    while ($res = mysqli_fetch_assoc($query)) {
                        $allcats[] = $res;
                    }
                    foreach ($allcats as $cat) {
                        echo "<option value='{$cat['ID']}'> {$cat['Name']} </option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-25 mx-auto">ADD</button>
        </form>
    </div>

<?php
} elseif ($action == 'insert') {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        echo '<h1 class="text-center mt-3 "> ADD item </h1>';
        // GET VALUES
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $cat = $_POST['cat'];
        $member = $id;
        $errores = [];
        $vaild = true;
        // vaildation
        if (empty($name)) {
            $errores[] = "name can't be empty";
            $vaild = false;
        }
        if (empty($description)) {
            $errores[] = "description can't be empty";
            $vaild = false;
        }
        if (empty($price)) {
            $errores[] = "price can't be empty";
            $vaild = false;
        }
        if (empty($country)) {
            $errores[] = "country can't be empty";
            $vaild = false;
        }
        if ($status == 0) {
            $errores[] = "status can't be empty";
            $vaild = false;
        }
        if ($member == 0) {
            $errores[] = "you must choose member";
            $vaild = false;
        }
        if ($cat == 0) {
            $errores[] = "you must choose categorie";
            $vaild = false;
        }
        if ($vaild === true) {
            // ADD IN DATABASE 
            $sql = "INSERT INTO items(items.Name,items.Description,Price,Add_Date,Country_Made,items.Status,Cat_ID,Member_ID) VALUES
            ('$name','$description','$price',NOW(),'$country','$status','$cat','$member')
            ";
            $query = mysqli_query($conn, $sql);
            echo "<h1 class='text-center mt-3 '> Item ADDED Successfully </h1>";
            header("Refresh:2; url=profile.php");
        } else {
            foreach ($errores as $error) {
                echo "<div  class='alert alert-danger container ' role='alert'>
                $error
              </div>";
                header("Refresh:5; url=newadd.php?action=add");
            }
        }
    } else {
        echo '<h1 class="text-center mt-3 "> ERROR </h1>';
    }
}

include $tpl . 'footer.php';
