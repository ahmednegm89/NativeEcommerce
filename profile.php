<?php
session_start();
$pagetitle = 'profile';
include "init.php";
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
if (isset($_SESSION['userid'])) {
    $id = $_SESSION['userid'];
}
$sql = " SELECT * FROM users WHERE Username = '{$_SESSION['username']}'";
$query = mysqli_query($conn, $sql);
$res = mysqli_fetch_assoc($query);


?>
<h1 class="text-center mt-3 "> Hello <strong><?php echo $_SESSION['username'] ?></strong> </h1>

<div class="container">
    <div class="card mt-3">
        <h5 class="card-title titi"> <i class="fa-solid fa-circle-info"></i> My Info :</h5>
        <div class="card-body">
            <p class="card-text"><i class="fa fa-unlock-alt fa-fw"></i> Name : <?php echo $res['Username'] ?></p>
            <p class="card-text"><i class="fa fa-envelope fa-fw"></i> Email : <?php echo $res['Email'] ?></p>
            <p class="card-text"><i class="fa fa-user fa-fw"></i> Full Name : <?php echo $res['FullName'] ?></p>
            <p class="card-text"><i class="fa fa-calendar fa-fw"></i> Joained at : <?php echo $res['Date'] ?></p>
        </div>
        <h5 class="card-title titi"> <i class="fa-solid fa-cart-shopping"></i> My Ads : <a href="newadd.php?action=add"> <i class="fa fa-plus"></i> Add one</a></h5>
        <div class="card-body d-flex flex-wrap justify-content-center align-items-center gap-5 ">
            <?php
            $sql2 = "SELECT items.*,users.Username FROM items JOIN users ON items.Member_ID = users.UserID WHERE users.Username = '{$_SESSION['username']}'";
            $query2 = mysqli_query($conn, $sql2);
            while ($res2 = mysqli_fetch_assoc($query2)) { ?>
                <div class="card mt-3 mb-1" style="width: 18rem;">
                    <img class="img-responsive" src="imgg.jpg" class="card-img-top" alt="itemimg">
                    <div class="info">
                        <a class="card-title carda" href="item.php?id=<?php echo $res2['item_ID'] ?>"><strong><?php echo $res2['Name'] ?></strong> </a>
                        <h6 class="card-title price-tag mt-3"> <strong><?php echo $res2['Price'] ?></strong> </h6>
                        <p class="card-text"><?php echo $res2['Description'] ?></p>
                    </div>
                </div>
            <?php  }
            ?>
        </div>
    </div>
</div>
<h1 class="text-center mt-3 "> All your comments </h1>
<?php
$sql3 = "SELECT * FROM `comments` 
WHERE comments.user_id = {$res['UserID']} AND comments.status = 1";
$query3 = mysqli_query($conn, $sql3);
while ($res3 = mysqli_fetch_assoc($query3)) { ?>
    <div class="container mb-3">
        <strong> Added at: <?php echo $res3['comment_date'] ?> </strong>
        <div class="comments">
            <img src="imgg.jpg" alt="">
            <input type="text" readonly class="form-control w-50" value="<?php echo $res3['Comment'] ?>"></input>
            <a type="button" class="btn btn-danger mx-2">delete</a>
        </div>
    </div>
<?php }
?>


<?php
include $tpl . 'footer.php';
?>

<style>
    .titi {
        background-color: #eee;
        width: fit-content;
    }

    .carda {
        text-decoration: none;
        color: black;
        font-size: 20px;
        cursor: pointer;
    }

    .info {
        padding: 15px;
    }

    .comments {
        display: flex;
        align-items: center;
    }

    .comments img {
        height: 50px;
        width: 60px;
        border-radius: 50%;
    }
</style>