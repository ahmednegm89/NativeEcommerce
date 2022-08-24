<nav class="navbar navbar-dark bg-dark navbar-expand-lg ">
    <div class="container ">
        <a class="navbar-brand" style="font-family: bold;" href="dashboard.php">ADMIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="Categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="items.php">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="members.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php">Comments</a>
                </li>
            </ul>
            <ul class="navbar-nav me-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['adminname'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="members.php?action=edit&userid=<?php echo $_SESSION['userid']; ?>">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="../index.php"> <strong>Visit site</strong> </a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>