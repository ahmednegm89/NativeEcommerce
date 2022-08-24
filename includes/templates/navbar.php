<nav class="navbar navbar-dark bg-dark navbar-expand-lg ">
    <div class="container ">
        <a class="navbar-brand" style="font-family: bold;" href="index.php">shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            $sql = " SELECT * FROM categories ORDER BY ID";
            $query = mysqli_query($conn, $sql);
            $allcats = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $allcats[] = $row;
            } ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        categories
                    </a>
                    <ul class="dropdown-menu catsli">
                        <?php foreach ($allcats as $cat) { ?>
                            <li class="nav-item">
                                <a class="nav-link " href="categories.php?id=<?php echo $cat['ID'] ?>"><?php echo $cat['Name'] ?></a>
                            </li>
                        <?php    }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
            if (isset($_SESSION['username'])) { ?>
                <ul class="navbar-nav me-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (isset($_SESSION['username'])) {
                                echo $_SESSION['username'];
                            } ?>
                        </a>
                        <ul class="dropdown-menu loll" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php     } else { ?>
                <ul class="navbar-nav me-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="login.php">
                            <i class="fa fa-user"></i>
                            log in
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="signup.php">
                            <i class="fa fa-user-plus"></i>
                            Sign up
                        </a>
                    </li>
                </ul>

            <?php    }
            ?>
        </div>
    </div>
</nav>

<style>
    .catsli {
        background-color: black;
    }
</style>