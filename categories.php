<?php
session_start();
$pagetitle = 'categories';
include "init.php";
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$sql = " SELECT items.*,users.Username AS name FROM items 
JOIN users ON items.Member_ID = users.UserID
WHERE Cat_ID  = '$id' AND items.Approve = 1 ORDER BY item_ID DESC ";
$query = mysqli_query($conn, $sql);
$allitems = [];
while ($row = mysqli_fetch_assoc($query)) {
    $allitems[] = $row;
}
?>
<div class="container">
    <div class="d-flex flex-wrap justify-content-center align-items-center gap-5">
        <?php
        if (!empty($allitems)) {
            foreach ($allitems as $item) { ?>
                <div class="">
                    <div class="card mt-3 mb-1">
                        <img class="img-responsive" src="imgg.jpg" class="card-img-top" alt="itemimg">
                        <div class="card-body">
                            <a class="card-title carda" href="item.php?id=<?php echo $item['item_ID'] ?>"><strong><?php echo $item['Name'] ?></strong> </a>
                            <h6 class="card-title price-tag"> <strong><?php echo $item['Price'] ?></strong> </h6>
                            <h6 class="card-title price-tag mt-3"> Added by : <strong><?php echo $item['name'] ?></strong> </h6>
                            <p class="card-text"><?php echo $item['Description'] ?></p>
                        </div>
                    </div>
                </div>
        <?php    }
        } else {
            echo "<h1 class='text-center mt-3 '> <strong> No items here </strong> </h1>";
        }
        ?>
    </div>
</div>


<?php
include $tpl . 'footer.php';

?>

<style>
    .price-tag {
        background-color: #eee;
        width: fit-content;

    }

    .card {
        width: 220px;
        height: 350px;
        overflow: hidden;
    }

    .carda {
        text-decoration: none;
        color: black;
        font-size: 20px;
        cursor: pointer;
    }
</style>