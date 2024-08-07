<?php
include_once "../includes/db_connection.php";
session_start();

if (isset($_SESSION['author_role']) && ($_SESSION['author_role'] === 'admin' || $_SESSION['author_role'] === 'author')) {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
} else {
    header("Location: login.php?message=Please+Login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update'])) {
    $author_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_name"]));
    $author_email = filter_var($_POST["author_email"], FILTER_SANITIZE_EMAIL);
    $author_password = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_password"]));
    $author_bio = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_bio"]));

    // Checking empty fields
    if (empty($author_name) || empty($author_email) || empty($author_bio)) {
        $message = "Empty Fields";
    } else if (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email";
    } else {
        $author_id = $_SESSION['author_id'];
        if (empty($author_password)) {
            // User doesn't want to change the password
            $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio' WHERE author_id='$author_id'";
        } else {
            // Hash the new password
            $hashed_password = password_hash($author_password, PASSWORD_DEFAULT);
            $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_password='$hashed_password', author_bio='$author_bio' WHERE author_id='$author_id'";
        }

        if (mysqli_query($conn, $sql)) {
            $_SESSION['author_name'] = $author_name;
            $_SESSION['author_email'] = $author_email;
            $_SESSION['author_bio'] = $author_bio;
            header("Location: index.php?message=Record+Updated");
            exit();
        } else {
            $message = "Error updating record";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="../style/dashboard.css">
</head>

<body>
    <header class="navbar sticky-top bg-dark shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Company name</a>
        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                    <svg class="bi">
                        <use xlink:href="#search" />
                    </svg>
                </button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <svg class="bi">
                        <use xlink:href="#list" />
                    </svg>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">Reports</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">Integrations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="logout.php">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Admin Panel</h1>
                    <h6>Welcome! <?php echo $_SESSION['author_name']?> | Your Role is <?php echo $_SESSION['author_role']?> </h6>
                </div>

                <div id="admin-index-form">
                    <?php
                    if (isset($message)) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">' . $message . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    ?>

                    <h1>Your Profile</h1>
                    <form action="" method="POST">
                        <div class="mb-3 mt-3">
                            <label for="author_name">Name:</label>
                            <input type="text" class="form-control" id="author_name" placeholder="Enter name" name="author_name" value="<?php echo $_SESSION['author_name'] ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="author_email">Email:</label>
                            <input type="email" class="form-control" id="author_email" placeholder="Enter email" name="author_email" value="<?php echo $_SESSION['author_email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="author_password">Password:</label>
                            <input type="password" class="form-control" id="author_password" placeholder="Enter password" name="author_password">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="author_bio">Your Bio:</label>
                            <textarea
