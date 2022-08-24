<?php
session_start();
if (isset($_SESSION['adminname'])) {
    $pagetitle = 'Dashboard';
    include "init.php";
    $latest =  getlatest("*", "users", 'UserID', 5);
    $latestiems =  latestiems("*", "items", 'item_ID', 5);
    // DASHBOARD
?>
    <div class="container home-stats">
        <h1 class="text-center mt-3" style="font-family: bold;"> DASHBOARD </h1>
        <div class="d-flex gap-5 text-center mt-3">
            <div class="Tmem w-25 rounded-2 d-flex flex-column justify-content-center " style=" height:120px;">
                <i class="fa fa-users fa-xl mb-3 mt-3 "></i> total members
                <span class="fs-2"> <a href="members.php"><?php echo getcount('UserID', 'users'); ?></a></span>
            </div>
            <div class="Pmem w-25 rounded-2 d-flex flex-column justify-content-center ">
                <i class="fa fa-user-plus fa-xl mb-3 mt-3 "></i> pending members
                <span class="fs-2"> <a href="members.php?page=pending"><?php echo getpending('UserID', 'users'); ?></a> </span>
            </div>
            <div class="Titm w-25 rounded-2 d-flex flex-column justify-content-center ">
                <i class="fa fa-tags fa-xl mb-3 mt-3 "></i> total items
                <span class="fs-2"><a href="items.php"><?php echo getcount('Name', 'items'); ?></a></span>
            </div>
            <div class="Tcom w-25 rounded-2 d-flex flex-column justify-content-center ">
                <i class="fa-solid fa-comments fa-xl mb-3 mt-3"></i> total comments
                <span class="fs-2"><a href="comments.php"><?php echo getcount('Comment', 'comments'); ?></a></span>
            </div>
        </div>
    </div>
    <div class="container mt-5 d-flex gap-3">
        <div class="card">
            <h5 class="card-header"> <i class="fa fa-users"></i> latest registered users</h5>
            <div class="card-body">
                <?php
                foreach ($latest as $user) {
                    echo "<div class = 'editdiv' >";
                    echo "<p class='card-text'> {$user['Username']} </p>";
                    echo "<a class='btn btn-primary' href='members.php?action=edit&userid={$user['UserID']}' role='button'><i class='fa-solid fa-edit'></i> Edit </a>";
                    if ($user['RegStatus'] == 0) {
                        echo "<a class='btn btn-success' href='members.php?action=activate&userid={$user['UserID']}' role='button'><i class='fa-solid fa-check'></i> activate </a>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header"> <i class="fa fa-tag"></i> latest items</h5>
            <div class="card-body">
                <?php
                foreach ($latestiems as $item) {
                    echo "<div class = 'editdiv' >";
                    echo "<p class='card-text'> {$item['Name']} </p>";
                    echo "<a class='btn btn-primary' href='items.php?action=edit&id={$item['item_ID']}' role='button'><i class='fa-solid fa-edit'></i> Edit </a>";
                    if ($item['Approve'] == 0) {
                        echo "<a class='btn btn-success' href='items.php?action=approve&id={$item['item_ID']}' role='button'><i class='fa-solid fa-check'></i> Approve </a>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

<?php } else {
    header("location:index.php");
}

?>


<style>
    .home-stats div {
        color: white;
    }

    .home-stats div span a {
        text-decoration: none;
        color: white;
    }

    .home-stats .Tmem {
        background-color: #2980b9;
    }

    .home-stats .Pmem {
        background-color: #27ae60;
    }

    .home-stats .Titm {
        background-color: #16a085;
    }

    .home-stats .Tcom {
        background-color: #8e44ad;
    }

    .card {
        min-width: 43vw;
    }

    .editdiv:nth-child(even) {
        background-color: #eee;
    }

    .editdiv {
        margin-top: 5px;
    }

    .card-body * {
        border-radius: 10px;
    }

    .card-body .editdiv {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 5px;
    }

    .card-body .editdiv p {
        margin-top: 10px;
    }
</style>