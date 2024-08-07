<?php
include_once "../includes/db_connection.php";
//include_once "../includes/light_nav_bar.php";

session_start();
if (isset($_SESSION['author_role']) && $_SESSION['author_role'] === 'admin') {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Category</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="../style/dashboard.css">
</head>

<body>

    <header class="navbar sticky-top bg-dark shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="index.php">Company name</a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false"
                    aria-label="Toggle search">
                </button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                </button>
            </li>
        </ul>
    </header>

    <?php include_once "sidebar.incl.php"?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Categories</h1>
            <h6>Welcome! <?php echo $_SESSION['author_name']?> | Your Role is
                <?php echo $_SESSION['author_role']?> </h6>
        </div>
        <h1>ALL CATEGORIES:</h1>
        <button type="button" class="btn btn-info" id="addcategorybutton">Add New</button>
        <hr>
        <div style="display: none;" id="addCategoryForm">
            <form action="addcategory.php" method="post">
                <label for="category_name" class="form-label">Category:</label>
                <input type="text" class="form-control" name="category_name" id="category_name"
                    aria-describedby="category_name" placeholder="Enter Category Name"><br>
                <button name="submit" class="btn btn-success">Add Category</button>
            </form><br>
        </div>
        <table class="table">
            <thead>
                <th scope="col">Category Id</th>
                <th scope="col">Category Name</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <?php
            $sql = "SELECT * FROM `category` ORDER BY category_id";
            $result = mysqli_query($conn, $sql);
    
            while($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];

        ?>
            <tr>
                <th scope="row"><?php echo $category_id;?></th>
                <td><?php echo $category_name;?></td>

            </tr>


            <?php }?>
        </table>
    </main>
    </div>

    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/jQuery.js"></script>
    <script src="../style/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
    <script src="../style/dashboard.js"></script>
</body>

</html>
<?php }

else {
    header("Location: login.php?message=Please+Login");
    exit();
}

?>