<?php
session_start();
$pagetitle = 'Comments';
if (isset($_SESSION['adminname'])) {
    include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    if ($action == 'manage') {
        $sql = "SELECT comments.*,items.Name,users.Username
        FROM 
         comments
        INNER JOIN 
         items 
        ON 
         comments.item_id = items.item_ID
        INNER JOIN
        users 
        ON 
         comments.user_id = users.UserID";
        $query = mysqli_query($conn, $sql);
?>
        <!-- users table -->
        <div class="container">
            <h1 class="text-center mt-3 "> Manage Comments </h1>
            <table class="table table-bordered table-hover mt-5 shadow p-3 mb-3 bg-body rounded">
                <thead class="text-center">
                    <tr class="tabelh">
                        <th scope="col">ID</th>
                        <th scope="col">Comment</th>
                        <th scope="col">product</th>
                        <th scope="col">user</th>
                        <th scope="col">Data</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // LOOP AND PUT USERS DATA IN Table
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr class="text-center">
                            <td><?php echo $row['C_ID'] ?></td>
                            <td><?php echo $row['Comment'] ?></td>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo $row['Username'] ?></td>
                            <td style="width:125px;"><?php echo $row['comment_date'] ?></td>
                            <td class="text-center controltr">
                                <a class="btn btn-primary" href="comments.php?action=edit&id=<?php echo $row['C_ID'] ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a class="btn btn-danger conf" href="comments.php?action=delete&id=<?php echo $row['C_ID'] ?>" role="button"><i class="fa-solid fa-eraser"></i> Delete</a>
                                <?php
                                if ($row['status'] == 0) { ?>
                                    <a class="btn btn-success" href="comments.php?action=approve&id=<?php echo $row['C_ID'] ?>" role="button"><i class="fa-solid fa-check"></i> Aprrove</a>
                                <?php    }
                                ?>
                            </td>
                        </tr>
                    <?php  }
                    ?>
                </tbody>
            </table>
        </div>


        <?php } elseif ($action == 'edit') {
        // get commentid from GET and check vaildation
        $C_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // get comment
        $sql = "SELECT * FROM comments WHERE C_ID = '$C_id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        if (mysqli_num_rows($query) > 0) { ?>
            <h1 class="text-center mt-3 "> Edit comment </h1>
            <!-- ADD form -->
            <div class="container">
                <form class="d-flex flex-column" action="?action=update" method="POST">
                    <input type="hidden" name="C_id" value="<?php echo $C_id ?>">
                    <div class="mb-3">
                        <label for="Name" class="form-label">Comment</label>
                        <textarea type="text" name="comment" class="form-control" id="Name" aria-describedby="emailHelp" rows="4" cols="50" required><?php echo $row['Comment'] ?>
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-25 mx-auto">Update</button>
                </form>
            </div>
<?php   } else {
            echo "<h1 class='text-center mt-3'> NO SUCH ID </h1>";
            header("Refresh:1; url=comments.php");
        }
    } elseif ($action == 'update') {
        echo '<h1 class="text-center mt-3 "> UPDATE Comment </h1>';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // GET VALUES
            $C_id = $_POST['C_id'];
            $comment = $_POST['comment'];
            $errores = [];
            $vaild = true;
            // vaildation   
            if (empty($comment)) {
                $errores[] = "comment cant be empty";
                $vaild = false;
            }
            if ($vaild === true) {
                // UPDATE IN DATABASE 
                $sql = "UPDATE comments SET comments.Comment = '$comment' WHERE comments.C_ID = '$C_id'";
                $query = mysqli_query($conn, $sql);
                echo "<h1 class='text-center mt-3 '>  UPDATED  Successfully </h1>";
                header("Refresh:2; url=comments.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:3; url=comments.php?action=edit&id=$C_id");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=comments.php");
        }
    } elseif ($action == 'delete') {
        // get commentid from GET and check vaildation
        $C_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // delete all comment data
        $sql = " DELETE FROM comments WHERE C_id = '$C_id'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> comment DELETED </h1>';
            header("Refresh:1; url=comments.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=comments.php");
        }
    } elseif ($action == 'approve') {
        // get commentid from GET and check vaildation
        $C_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // approve comment
        $sql = " UPDATE comments SET status = 1 WHERE C_id = '$C_id'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> comment approved </h1>';
            header("Refresh:1; url=comments.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=comments.php");
        }
    }
} else {
    header("location:index.php");
    exit();
}
?>
<style>
    .tabelh {
        background-color: #8E44AD;
        color: white;
    }

    .btn-add {
        background-color: #8E44AD;
        color: white;
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