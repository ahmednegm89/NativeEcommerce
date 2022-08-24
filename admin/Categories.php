<?php
session_start();
$pagetitle = 'Categories';
if (isset($_SESSION['adminname'])) {
    include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    if ($action == 'manage') {
        $sort = 'ASC';
        $sort_arr = ['ASC', 'DESC'];
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {
            $sort = $_GET['sort'];
        }
        $sql = "SELECT * FROM categories ORDER BY ID $sort ";
        $query = mysqli_query($conn, $sql);
?>
        <div class="container">
            <h1 class="text-center mt-3 "> <i class='fa fa-edit' style="color: #0C1D4C;"></i> Manages Categories </h1>
            <div>
                <h4> <i class="fa fa-sort" style="color: #0C1D4C;"></i> order:</h4>
                <a href="?sort=ASC" class="btn btn-add <?php if ($_GET['sort'] == 'ASC') {
                                                            echo 'active';
                                                        }; ?>"> ASC </a>
                <a href="?sort=DESC" class="btn btn-add <?php if ($_GET['sort'] == 'DESC') {
                                                            echo 'active';
                                                        }; ?>"> DESC </a>
            </div>
            <table class="table table-bordered table-hover mt-3 shadow p-3 mb-3 bg-body rounded">
                <thead class="text-center">
                    <tr class="tableh">
                        <th scope="col">#ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Visibility</th>
                        <th scope="col">Allow_Comment</th>
                        <th scope="col">Allow_Ads</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // LOOP AND PUT USERS DATA IN Table
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr class="text-center">
                            <th scope="row"><?php echo $row['ID'] ?></th>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php if ($row['Description'] == '') {
                                    echo 'No Description';
                                } else {
                                    echo $row['Description'];
                                };  ?></td>
                            <td><?php
                                if ($row['Visibility'] == 1) {
                                    echo "<strong> <i class ='fa fa-eye-slash' ></i> Hidden</strong>";
                                } else {
                                    echo 'visible';
                                }
                                ?></td>
                            <td><?php
                                if ($row['Allow_Comment']  == 1) {
                                    echo "<strong><i class ='fa fa-close' ></i> Not Allowed</strong>";
                                } else {
                                    echo 'Allowed';
                                }

                                ?></td>
                            <td><?php
                                if ($row['Allow_Ads']  == 1) {
                                    echo "<strong><i class ='fa fa-close' ></i> Not Allowed</strong>";
                                } else {
                                    echo 'Allowed';
                                }
                                ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="categories.php?action=edit&id=<?php echo $row['ID'] ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a class="btn btn-danger conf" href="categories.php?action=delete&id=<?php echo $row['ID'] ?>" role="button"><i class="fa-solid fa-eraser"></i> Delete</a>
                            </td>
                        </tr>
                    <?php  }
                    ?>
                </tbody>
            </table>
            <a href="?action=add" class="btn btn-add"> <i class="fa fa-plus"></i> ADD NEW ONE </a>
        </div>

    <?php   } elseif ($action == 'add') { ?>
        <h1 class="text-center mt-3 "> Add Page </h1>
        <!-- ADD form -->
        <div class="container">
            <form class="d-flex flex-column" action="?action=insert" method="POST">
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" id="description">
                </div>
                <div class="mb-3">
                    <label for="Ordering" class="form-label">Ordering</label>
                    <input type="text" name="ordering" class="form-control" id="Ordering">
                </div>
                <div class="mb-3 left-border">
                    <label class="form-label">Visible</label>
                    <div class="mb-1">
                        <input class="form-check-input" type="radio" name="visible" id="v-Yes" value="0" checked>
                        <label class="form-check-label" for="v-Yes">
                            YES
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="visible" id="v-No" value="1">
                        <label class="form-check-label" for="v-No">
                            NO
                        </label>
                    </div>
                </div>
                <div class="mb-3 left-border">
                    <label class="form-label">Comment</label>
                    <div class="mb-1">
                        <input class="form-check-input" type="radio" name="comment" id="c-Yes" value="0" checked>
                        <label class="form-check-label" for="c-Yes">
                            YES
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="comment" id="c-No" value="1">
                        <label class="form-check-label" for="c-No">NO</label>
                    </div>
                </div>
                <div class="mb-3 left-border">
                    <label class="form-label">Ads</label>
                    <div class="mb-1">
                        <input class="form-check-input" type="radio" name="ads" id="a-Yes" value="0" checked>
                        <label class="form-check-label" for="a-Yes">YES</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="ads" id="a-No" value="1">
                        <label class="form-check-label" for="a-No">NO</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-25 mx-auto">ADD</button>
            </form>
        </div>

        <?php
    } elseif ($action == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<h1 class="text-center mt-3 "> ADD categorie </h1>';
            // GET VALUES
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visible = $_POST['visible'];
            $comment = $_POST['comment'];
            $ads = $_POST['ads'];
            // vaildation
            $sql = "SELECT Name FROM categories ";
            $query = mysqli_query($conn, $sql);
            $allcatsnames = [];
            while ($res = mysqli_fetch_row($query)) {
                $allcatsnames[] = $res[0];
            }
            if (in_array($name, $allcatsnames)) {
                echo "<h1 class='text-center mt-3 '> categories already exists </h1>";
                header("Refresh:2; url=Categories.php?action=add");
            } else {
                if (!empty($name)) {
                    $sql = "INSERT INTO categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) 
                    VALUES
                    ('$name','$description','$ordering','$visible','$comment','$ads')
                    ";
                    $query = mysqli_query($conn, $sql);
                    echo "<h1 class='text-center mt-3 '>  ADDED  Successfully </h1>";
                    header("Refresh:2; url=Categories.php");
                } else {
                    echo "<h1 class='text-center mt-3 '>  Name can not be empty </h1>";
                    header("Refresh:2; url=Categories.php?action=add");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
        }
    } elseif ($action == 'edit') {
        // get catid from GET and check vaildation
        $catid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // get all user data
        $sql = "SELECT * FROM categories  WHERE ID = '$catid'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);

        if (mysqli_num_rows($query) > 0) { ?>
            <h1 class="text-center mt-3 "> Edit Page </h1>
            <!-- ADD form -->
            <div class="container">
                <form class="d-flex flex-column" action="?action=update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>">
                    <div class="mb-3">
                        <label for="Name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required value="<?php echo $row['Name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" id="description" value="<?php echo $row['Description'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Ordering" class="form-label">Ordering</label>
                        <input type="text" name="ordering" class="form-control" id="Ordering" value="<?php echo $row['Ordering'] ?>">
                    </div>
                    <div class="mb-3 left-border">
                        <label class="form-label">Visible</label>
                        <div class="mb-1">
                            <input class="form-check-input" type="radio" name="visible" id="v-Yes" value="0" <?php if ($row['Visibility'] == 0) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                            <label class="form-check-label" for="v-Yes">
                                YES
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="radio" name="visible" id="v-No" value="1" <?php if ($row['Visibility'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                            <label class="form-check-label" for="v-No">
                                NO
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 left-border">
                        <label class="form-label">Comment</label>
                        <div class="mb-1">
                            <input class="form-check-input" type="radio" name="comment" id="c-Yes" value="0" <?php if ($row['Allow_Comment'] == 0) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                            <label class="form-check-label" for="c-Yes">
                                YES
                            </label>
                        </div>
                        <div>
                            <input class="form-check-input" type="radio" name="comment" id="c-No" value="1" <?php if ($row['Allow_Comment'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                            <label class="form-check-label" for="c-No">NO</label>
                        </div>
                    </div>
                    <div class="mb-3 left-border">
                        <label class="form-label">Ads</label>
                        <div class="mb-1">
                            <input class="form-check-input" type="radio" name="ads" id="a-Yes" value="0" <?php if ($row['Allow_Ads'] == 0) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                            <label class="form-check-label" for="a-Yes">YES</label>
                        </div>
                        <div>
                            <input class="form-check-input" type="radio" name="ads" id="a-No" value="1" <?php if ($row['Allow_Ads'] == 1) {
                                                                                                            echo 'checked';
                                                                                                        } ?>>
                            <label class="form-check-label" for="a-No">NO</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-25 mx-auto">Update</button>
                </form>
            </div>
<?php    } else {
            echo "<h1 class='text-center mt-3'> NO SUCH ID </h1>";
            header("Refresh:1; url=Categories.php");
        }
    } elseif ($action == 'update') {
        echo '<h1 class="text-center mt-3 "> UPDATE Categories </h1>';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // GET VALUES
            $catid = $_POST['catid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visible = $_POST['visible'];
            $comment = $_POST['comment'];
            $ads = $_POST['ads'];
            $errores = [];
            $vaild = true;
            // vaildation   
            $sql = "SELECT Name FROM categories WHERE ID != $catid ";
            $query = mysqli_query($conn, $sql);
            $allcatsnames = [];
            while ($res = mysqli_fetch_row($query)) {
                $allcatsnames[] = $res[0];
            }
            if (in_array($name, $allcatsnames)) {
                $errores[] = "categorie already exists";
                $vaild = false;
            }
            if (empty($name)) {
                $errores[] = "username cant be empty";
                $vaild = false;
            }
            if ($vaild === true) {
                // UPDATE IN DATABASE 
                $sql = "UPDATE Categories 
                SET Categories.Name = '$name',Categories.Description = '$description',
                Ordering = '$ordering',Visibility ='$visible',
                Allow_Comment = '$comment',Allow_Ads = '$ads'
                WHERE ID = '$catid'  ";
                $query = mysqli_query($conn, $sql);
                echo "<h1 class='text-center mt-3 '>  UPDATED  Successfully </h1>";
                header("Refresh:4; url=Categories.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:3; url=Categories.php?action=edit&id=$catid");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=Categories.php");
        }
    } elseif ($action == 'delete') {
        // get catid from GET and check vaildation
        $catid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // delete all user data
        $sql = " DELETE FROM Categories WHERE ID = '$catid'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> Categorie DELETED </h1>';
            header("Refresh:2; url=Categories.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=Categories.php");
        }
    }
} else {
    header("location:index.php");
    exit();
}

?>

<style>
    .left-border {
        border-left: 5px solid #0d6efd;
    }

    .left-border * {
        margin-left: 5px;
    }

    .tableh {
        background-color: #0c1d4c;
    }

    .tableh th {
        color: white;
    }

    .btn-add {
        background-color: #0c1d4c;
        color: white;
    }

    .active {
        background-color: white;
        color: #0c1d4c;
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