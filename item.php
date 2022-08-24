<?php
session_start();
if (isset($_SESSION['commenterr'])) {
    $commenterr = $_SESSION['commenterr'];
    unset($_SESSION['commenterr']);
}
$pagetitle = 'Shop';
include "init.php";
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$sql2 = "SELECT items.*,categories.ID AS ID,categories.Name AS cat_name,users.* FROM items
JOIN categories ON items.Cat_ID = categories.ID
JOIN users ON items.Member_ID = users.UserID
WHERE item_ID = '$id'";
$query2 = mysqli_query($conn, $sql2);
$res2 = mysqli_fetch_assoc($query2);
if ($res2['Approve'] == 0) {
    header("location:index.php");
}
?>

<div class="container">
    <div class="card mt-3 nobord">
        <div class="card-body d-flex flex-wrap justify-content-center align-items-center gap-5 ">
            <div class="card mt-3 mb-1 nobord " style="width: 30rem;">
                <img class="img-responsive" src="imgg.jpg" class="card-img-top" alt="itemimg">
                <div class="info">
                    <h3 class="card-title carda"><strong><?php echo $res2['Name'] ?></strong> </>
                        <h6 class="card-title price-tag mt-3"> <strong><?php echo $res2['Price'] ?></strong> </h6>
                        <p class="card-text"><?php echo $res2['Description'] ?></p>
                        <p class="card-text"><i class="fa fa-calendar fa-fw"></i> data added : <strong><?php echo $res2['Add_Date'] ?></strong> </p>
                        <p class="card-text"><i class="fa fa-user fa-fw"></i> added by : <strong><?php echo $res2['Username'] ?></strong> </p>
                        <p class="card-text"><i class="fa fa-flag fa-fw"></i> Made in <strong><?php echo $res2['Country_Made'] ?></strong> </p>
                        <p class="card-text"><i class="fa fa-star fa-fw"></i> Rating : <strong><?php echo $res2['Rating'] ?></strong> Out of 5 </p>
                        <p class="card-text"><i class="fa fa-tag fa-fw"></i> category : <strong> <a href="categories.php?id=<?php echo $res2['ID'] ?>"><?php echo $res2['cat_name'] ?></a> </strong> </p>
                </div>
            </div>
        </div>
    </div>
</div>
<h1 class="text-center mt-3 "> All comments </h1>
<?php
$sql3 = "SELECT comments.*,users.Username FROM `comments` 
JOIN users ON comments.user_id = users.UserID
WHERE comments.item_id = $id AND comments.status = 1";
$query3 = mysqli_query($conn, $sql3);
while ($res3 = mysqli_fetch_assoc($query3)) { ?>
    <div class="container mb-3">
        <strong> Added by: <?php echo $res3['Username'] ?> At: <?php echo $res3['comment_date'] ?> </strong>
        <div class="comments">
            <img src="imgg.jpg" alt="">
            <input type="text" readonly class="form-control w-50" value="<?php echo $res3['Comment'] ?>"></input>
        </div>
    </div>
<?php }
?>
<?php
if (isset($_SESSION['username']) or isset($_SESSION['adminname'])) { ?>
    <div class="container mt-5">
        <h5>Add comment</h5>
        <form method="post" action="hcomments.php">
            <div class="comments">
                <img src="imgg.jpg" alt="">
                <input type="hidden" name="itemid" value="<?php echo $res2['item_ID'] ?>">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['userid'] ?>">
                <input type="text" name="comment" class="form-control w-50 ml-1" required></input>
                <button type="submit" class="btn btn-primary mx-5">Publish</button>
            </div>
        </form>
        <h5><?php if (isset($commenterr)) {
                echo $commenterr;
            } ?></h5>
    </div>
<?php } else { ?>
    <h5 class="container"><a href="login.php">Login</a> to Add comment</h5>
<?php }
?>


<?php
include $tpl . 'footer.php';
?>


<style>
    .nobord {
        border: none;
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