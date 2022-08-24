<?php
session_start();
$pagetitle = 'Shop';
include "init.php";
?>
<div class="container">
    <div class="card mt-3 nobord">
        <div class="card-body d-flex flex-wrap justify-content-center align-items-center gap-5 ">
            <?php
            $sql2 = "SELECT items.*,users.Username AS name FROM items
            JOIN users ON items.Member_ID = users.UserID
            WHERE items.Approve =1
            ORDER BY item_ID DESC";
            $query2 = mysqli_query($conn, $sql2);
            while ($res2 = mysqli_fetch_assoc($query2)) { ?>
                <div class="card mt-3 mb-1 " style="width: 18rem;">
                    <img class="img-responsive" src="imgg.jpg" class="card-img-top" alt="itemimg">
                    <div class="info">
                        <a class="card-title carda" href="item.php?id=<?php echo $res2['item_ID'] ?>"><strong><?php echo $res2['Name'] ?></strong> </a>
                        <h6 class="card-title price-tag mt-3"> <strong><?php echo $res2['Price'] ?></strong> </h6>
                        <h6 class="card-title price-tag mt-3"> Added by : <strong><?php echo $res2['name'] ?></strong> </h6>
                        <p class="card-text"><?php echo $res2['Description'] ?></p>
                    </div>
                </div>
            <?php  }
            ?>
        </div>
    </div>
</div>
<?php
include $tpl . 'footer.php';
?>

<style>
    .carda {
        text-decoration: none;
        color: black;
        font-size: 20px;
        cursor: pointer;
    }

    .info {
        padding: 15px;
    }

    .nobord {
        border: none;
    }
</style>