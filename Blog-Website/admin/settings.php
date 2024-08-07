<?php
include_once "../includes/db_connection.php";
include_once "../includes/functions.php";

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
    <title>Page</title>
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
            <h1 class="h2">Settings</h1>
            <h6>Welcome! <?php echo $_SESSION['author_name']?> | Your Role is
                <?php echo $_SESSION['author_role']?> </h6>
        </div>
        <h1>ALL SETTINGS:</h1>
        <hr>
        <form method="post">
            HomePage Nav Title:
            <input type="text" name="home_light_nav_bar_title" class="form-control" placeholder="Enter Title"
                value="<?php getSettingValue('home_light_nav_bar_title'); ?>"><br>
            HomePage Nav Description:
            <input type="text" name="home_light_nav_bar_desc" class="form-control" placeholder="Enter Description"
                value="<?php getSettingValue('home_light_nav_bar_desc'); ?>"><br>

            <button name="submit" class="btn btn-success">Update Settings</button><br>
        </form>
        <?php
            if(isset($_POST['submit'])){
                $barTitle = mysqli_real_escape_string($conn, $_POST['home_light_nav_bar_title']);
                $barDesc = mysqli_real_escape_string($conn, $_POST['home_light_nav_bar_desc']);

                setSettingValue("home_light_nav_bar_title", $barTitle);
                setSettingValue("home_light_nav_bar_desc", $barDesc);
                echo "Settings Updated";
                
            }
        
        ?>



    </main>
    </div>

    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../style/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
    <script src="../style/dashboard.js"></script>
</body>

</html>
<?php
}else {
    header("Location: login.php?message=Please+Login");
    exit();
}

?>