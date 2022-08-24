<?php
session_start();
$pagetitle = 'Items';
if (isset($_SESSION['adminname'])) {
    include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    if ($action == 'manage') {
        $sort = 'ASC';
        $sort_arr = ['ASC', 'DESC'];
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {
            $sort = $_GET['sort'];
        }
        // get all cats data
        $sql = "SELECT items.*,categories.Name AS cat_name ,users.Username
        FROM items 
        INNER JOIN categories ON items.Cat_ID = categories.ID
        INNER JOIN users ON items.Member_ID = users.UserID ORDER BY item_ID $sort";
        $query = mysqli_query($conn, $sql);
?>
        <!-- users table -->
        <div class="container">
            <h1 class="text-center mt-3 "> Manages Items </h1>
            <div>
                <h4> <i class="fa fa-sort" style="color: #16A085;"></i> order:</h4>
                <a href="?sort=ASC" class="btn btn-add <?php if ($_GET['sort'] == 'ASC') {
                                                            echo 'active';
                                                        }; ?>"> ASC </a>
                <a href="?sort=DESC" class="btn btn-add <?php if ($_GET['sort'] == 'DESC') {
                                                            echo 'active';
                                                        }; ?>"> DESC </a>
            </div>
            <table class="table table-bordered table-hover mt-3 shadow p-3 mb-3 bg-body rounded">
                <thead class="text-center">
                    <tr class="tabelh">
                        <th scope="col">#ID</th>
                        <th scope="col"><a href="" class="OR">Name</a></th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Add_Date</th>
                        <th scope="col">Country_Made</th>
                        <th scope="col">category</th>
                        <th scope="col">Member</th>
                        <th scope="col">Control</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // LOOP AND PUT USERS DATA IN Table
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr class="text-center">
                            <th scope="row"><?php echo $row['item_ID'] ?></th>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo $row['Description'] ?></td>
                            <td><?php echo $row['Price'] ?></td>
                            <td style="width:125px;"><?php echo $row['Add_Date'] ?></td>
                            <td><?php echo $row['Country_Made'] ?></td>
                            <td><?php echo $row['cat_name'] ?></td>
                            <td><?php echo $row['Username'] ?></td>
                            <td class="text-center controltr">
                                <a class="btn btn-primary" href="items.php?action=edit&id=<?php echo $row['item_ID'] ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a class="btn btn-danger conf" href="items.php?action=delete&id=<?php echo $row['item_ID'] ?>" role="button"><i class="fa-solid fa-eraser"></i> Delete</a>
                                <?php
                                if ($row['Approve'] == 0) { ?>
                                    <a class="btn btn-success" href="items.php?action=approve&id=<?php echo $row['item_ID'] ?>" role="button"><i class="fa-solid fa-check"></i> Approve</a>
                                <?php    }
                                ?>
                            </td>
                        </tr>
                    <?php  }
                    ?>
                </tbody>
            </table>
            <a href="?action=add" class="btn btn-add"> <i class="fa fa-plus"></i> ADD NEW ONE </a>
        </div>


    <?php } elseif ($action == 'add') { ?>
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
                    <label for="Member" class="form-label">Member</label>
                    <select class="form-select" aria-label="Default select example" id="Member" name="member">
                        <option value="0"> .... </option>
                        <?php
                        $sql = "SELECT * FROM users WHERE GroupID != 1 ";
                        $query = mysqli_query($conn, $sql);
                        $allusers = [];
                        while ($res = mysqli_fetch_assoc($query)) {
                            $allusers[] = $res;
                        }
                        foreach ($allusers as $user) {
                            echo "<option value='{$user['UserID']}'> {$user['Username']} </option>";
                        }
                        ?>
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
            echo '<h1 class="text-center mt-3 "> ADD MEMBER </h1>';
            // GET VALUES
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $cat = $_POST['cat'];
            $member = $_POST['member'];
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
                header("Refresh:2; url=items.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:5; url=items.php?action=add");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
        }
    } elseif ($action == 'edit') {
        // get item from GET and check vaildation
        $itemid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // get all item data
        $sql = "SELECT * FROM items WHERE item_ID = '$itemid'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);

        if (mysqli_num_rows($query) > 0) { ?>
            <h1 class="text-center mt-3 "> Edit item Page </h1>
            <!-- ADD form -->
            <div class="container">
                <form class="d-flex flex-column" action="?action=update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                    <div class="mb-3">
                        <label for="Name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required value="<?php echo $row['Name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" id="Description" aria-describedby="emailHelp" value="<?php echo $row['Description'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="Price" aria-describedby="emailHelp" value="<?php echo $row['Price'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Country_Made" class="form-label">Made in ...</label>
                        <input type="text" name="country" class="form-control" id="Country_Made" aria-describedby="emailHelp" value="<?php echo $row['Country_Made'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Member" class="form-label">Condition</label>
                        <select class="form-select" aria-label="Default select example" id="Member" name="member">
                            <option value="1" <?php if ($row['Status'] == 1) {
                                                    echo 'selected';
                                                } ?>>New</option>
                            <option value="2" <?php if ($row['Status'] == 2) {
                                                    echo 'selected';
                                                } ?>>Like New</option>
                            <option value="3" <?php if ($row['Status'] == 3) {
                                                    echo 'selected';
                                                } ?>>Used</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Member" class="form-label">Member</label>
                        <select class="form-select" aria-label="Default select example" id="Member" name="member">
                            <?php
                            // get all users data
                            $sql = "SELECT * FROM users WHERE GroupID != 1 ";
                            $query = mysqli_query($conn, $sql);
                            $allusers = [];
                            while ($res = mysqli_fetch_assoc($query)) {
                                $allusers[] = $res;
                            }
                            foreach ($allusers as $user) { // select username who add this item
                            ?>
                                <option value='<?php echo $user['UserID']; ?>' <?php if ($user['UserID'] == $row['Member_ID']) {
                                                                                    echo 'selected';
                                                                                } ?>> <?php echo $user['Username']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label">categories</label>
                        <select class="form-select" aria-label="Default select example" id="categories" name="cat">
                            <?php
                            // get all cats data
                            $sql = "SELECT * FROM categories ";
                            $query = mysqli_query($conn, $sql);
                            $allcats = [];
                            while ($res = mysqli_fetch_assoc($query)) {
                                $allcats[] = $res;
                            }
                            foreach ($allcats as $cat) { // select the cat of the item
                            ?>
                                <option value='<?php echo $cat['ID']; ?>' <?php if ($cat['ID'] == $row['Cat_ID']) {
                                                                                echo 'selected';
                                                                            } ?>> <?php echo $cat['Name']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-25 mx-auto">Update Item</button>
                </form>
            </div>
<?php    } else {
            echo "<h1 class='text-center mt-3'> NO SUCH ID </h1>";
            header("Refresh:1; url=items.php");
        }
    } elseif ($action == 'update') {
        echo '<h1 class="text-center mt-3 "> UPDATE Categories </h1>';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // GET VALUES
            $itemid = $_POST['itemid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $member = $_POST['member'];
            $cat = $_POST['cat'];
            $errores = [];
            $vaild = true;
            // vaildation   
            if (empty($name)) {
                $errores[] = "username cant be empty";
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
            if ($vaild === true) {
                // UPDATE IN DATABASE 
                $sql = "UPDATE items 
                SET items.Name = '$name',items.Description = '$description',
                Price = '$price',Country_Made ='$country',
                Cat_ID = '$cat',Member_ID = '$member'
                WHERE item_ID = '$itemid'  ";
                $query = mysqli_query($conn, $sql);
                echo "<h1 class='text-center mt-3 '>  UPDATED  Successfully </h1>";
                header("Refresh:4; url=items.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:3; url=items.php?action=edit&id=$itemid");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=items.php");
        }
    } elseif ($action == 'delete') {
        // get itemid from GET and check vaildation
        $itemid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // delete all item data
        $sql = " DELETE FROM items WHERE item_ID = '$itemid'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> item DELETED </h1>';
            header("Refresh:1; url=items.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=items.php");
        }
    } elseif ($action == 'approve') {
        // get userid from GET and check vaildation
        $itemid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // approve item 
        $sql = " UPDATE items SET Approve = 1 WHERE item_ID = '$itemid'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> item approved </h1>';
            header("Refresh:2; url=items.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=items.php");
        }
    }
} else {
    header("location:index.php");
    exit();
}


?>

<style>
    .tabelh {
        background-color: #16A085;
    }

    .btn-add {
        background-color: #16A085;
        color: white;
    }

    .OR {
        text-decoration: none;
        color: #212529;
    }

    .OR:hover {
        color: white;
    }

    .controltr {
        min-width: 200px;
    }
</style>
<script>
    let btns = document.querySelectorAll(".conf");
    btns.forEach(btn => {
        btn.onclick = function conf() {
            return confirm("Are you sure?");
        }
    });
</script>