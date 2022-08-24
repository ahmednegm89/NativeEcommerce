<?php
session_start();
if (isset($_SESSION['adminname'])) {
    $pagetitle = 'Members';
    include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    if ($action == 'manage') { // manage all users

        // manage pending members
        $plus = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $plus = 'AND RegStatus != 1 ';
        }
        $sort = 'ASC';
        $sort_arr = ['ASC', 'DESC'];
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {
            $sort = $_GET['sort'];
        }
        // get all users data
        $sql = "SELECT * FROM users WHERE GroupID != 1 $plus ORDER BY UserID $sort ";
        $query = mysqli_query($conn, $sql);
?>
        <!-- users table -->
        <div class="container">
            <h1 class="text-center mt-3 "> Manages Members </h1>
            <div>
                <h4> <i class="fa fa-sort" style="color: #2980B9;"></i> order:</h4>
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
                        <th scope="col">UserName</th>
                        <th scope="col">Email</th>
                        <th scope="col">FullName</th>
                        <th scope="col">Registered Date</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // LOOP AND PUT USERS DATA IN Table
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                        <tr class="text-center">
                            <th scope="row"><?php echo $row['UserID'] ?></th>
                            <td><?php echo $row['Username'] ?></td>
                            <td><?php echo $row['Email'] ?></td>
                            <td><?php echo $row['FullName'] ?></td>
                            <td><?php echo $row['Date'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="members.php?action=edit&userid=<?php echo $row['UserID'] ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a class="btn btn-danger conf" href="members.php?action=delete&userid=<?php echo $row['UserID'] ?>" role="button"><i class="fa-solid fa-eraser"></i> Delete</a>
                                <?php
                                if ($row['RegStatus'] == 0) { ?>
                                    <a class="btn btn-success" href="members.php?action=activate&userid=<?php echo $row['UserID'] ?>" role="button"><i class="fa-solid fa-check"></i> Activate</a>
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


    <?php  } elseif ($action == 'add') { // add page 
        echo '<h1 class="text-center mt-3 "> ADD MEMBER </h1>';
    ?>
        <!-- ADD form -->
        <div class="container">
            <form class="d-flex flex-column" action="?action=insert" method="POST">
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
                <button type="submit" class="btn btn-primary w-25 mx-auto">ADD</button>
            </form>
        </div>
        <?php


    } elseif ($action == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<h1 class="text-center mt-3 "> ADD MEMBER </h1>';
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
                ('$user','$hpass','$email','$name',1,NOW())
                ";
                $query = mysqli_query($conn, $sql);
                echo "<h1 class='text-center mt-3 '>  ADDED  Successfully </h1>";
                header("Refresh:2; url=members.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:5; url=members.php?action=add");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
        }
    } elseif ($action == 'edit') { // edit page 
        // get userid from GET and check vaildation
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // get all user data
        $sql = "SELECT * FROM users  WHERE UserID = '$userid' LIMIT 1  ";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        // check if user exists
        if (mysqli_num_rows($query) > 0) { ?>
            <!-- update head  -->
            <h1 class="text-center mt-3 "> Edit Member </h1>
            <!-- update form  -->
            <div class="container">
                <form class="d-flex flex-column" action="?action=update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" value="<?php echo $row['Username'] ?>" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="hidden" name="oldPassword" value="<?php echo $row['Password'] ?>">
                        <input type="Password" name="newPassword" class="form-control" id="pass" placeholder="leave it empty if not wanted to change">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $row['Email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="full" class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" id="full" value="<?php echo $row['FullName'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-25 mx-auto">Save</button>
                </form>
            </div>


        <?php } else {
            echo "<h1 class='text-center mt-3'> NO SUCH ID </h1>";
            header("Refresh:1; url=members.php");
        }
        ?>
        <!-- U.P.D.A.T.E -->
        <?php  } elseif ($action == 'update') {
        echo '<h1 class="text-center mt-3 "> UPDATE MEMBER </h1>';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // GET VALUES
            $id = clean($_POST['userid']);
            $user = clean($_POST['username']);
            $email = clean($_POST['email']);
            $name = clean($_POST['fullname']);
            $pass = '';
            $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : md5(clean($_POST['newPassword']));
            $errores = [];
            $vaild = true;
            // vaildation
            $sql = "SELECT Username FROM users WHERE UserID != $id ";
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

                // UPDATE IN DATABASE 
                $sql = "UPDATE users 
                SET Username = '$user',Email = '$email', FullName = '$name',users.Password ='$pass'
                WHERE UserID = '$id'  ";
                $query = mysqli_query($conn, $sql);
                echo "<h1 class='text-center mt-3 '>  UPDATED  Successfully </h1>";
        ?>
                <!-- countdown -->
                <h5 class="text-center mt-3" id="countdown"></h5>
                <script>
                    var timeleft = 3;
                    var downloadTimer = setInterval(function() {
                        if (timeleft <= 0) {
                            clearInterval(downloadTimer);
                        } else {
                            document.getElementById("countdown").innerHTML =
                                "You will be redirected To Members within " + timeleft + " seconds";
                        }
                        timeleft -= 1;
                    }, 1000);
                </script>
<?php
                header("Refresh:4; url=members.php");
            } else {
                foreach ($errores as $error) {
                    echo "<div  class='alert alert-danger container ' role='alert'>
                    $error
                  </div>";
                    header("Refresh:3; url=members.php?action=edit&userid=$id");
                }
            }
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=members.php");
        }
    } elseif ($action == 'delete') { // DELETE user
        // get userid from GET and check vaildation
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // delete all user data
        $sql = " DELETE FROM users WHERE UserID = '$userid' AND GroupID != 1  ";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> USER DELETED </h1>';
            header("Refresh:2; url=members.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=members.php");
        }
    } elseif ($action == 'activate') {
        // get userid from GET and check vaildation
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // activate user 
        $sql = " UPDATE  users SET RegStatus = 1 WHERE UserID = '$userid'";
        $query = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0) {
            echo '<h1 class="text-center mt-3 "> USER ACTIVATED </h1>';
            header("Refresh:2; url=members.php");
        } else {
            echo '<h1 class="text-center mt-3 "> ERROR </h1>';
            header("Refresh:1; url=members.php");
        }
    }
} else {
    header("location:index.php");
}

?>


<style>
    .tabelh {
        background-color: #2980B9;
        color: white;
    }

    .btn-add {
        background-color: #2980B9;
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