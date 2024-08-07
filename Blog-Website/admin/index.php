<?php
include_once "../includes/db_connection.php";
session_start();
if (isset($_SESSION['author_role']) && $_SESSION['author_role'] === 'admin' ||($_SESSION['author_role']) && $_SESSION['author_role'] === 'author') {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
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
            <h1 class="h2">Admin Panel</h1>
            <h6>Welcome! <?php echo $_SESSION['author_name']?> | Your Role is
                <?php echo $_SESSION['author_role']?> </h6>
        </div>

        <div id="admin-index-form">

            <h1>Your Profile</h1>
            <form action="" method="POST">
                <div class="mb-3 mt-3">
                    <label for="author_name">Name:</label>
                    <input type="text" class="form-control" id="author_name" placeholder="Enter name" name="author_name"
                        value="<?php echo$_SESSION['author_name']?>">
                </div>
                <div class="mb-3 mt-3">
                    <label for="author_email">Email:</label>
                    <input type="author_email" class="form-control" id="author_email" placeholder="Enter email"
                        name="author_email" value="<?php echo$_SESSION['author_email']?>">
                </div>
                <div class="mb-3">
                    <label for="author_password">Password:</label>
                    <input type="password" class="form-control" id="author_password" placeholder="Enter password"
                        name="author_password">
                </div>
                <div class="mb-3 mt-3">

                    <label for="author_bio">Your Bio:</label>
                    <textarea class="form-control" rows="5" id="author_bio" name="author_bio">
                            <?php echo $_SESSION['author_bio']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </form>
            <?php
                        if($_SERVER['REQUEST_METHOD'] === "POST") {
                            $author_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_name"]));
                            $author_email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_email"]));
                            $author_password = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_password"]));
                            $author_bio = mysqli_real_escape_string($conn, htmlspecialchars($_POST["author_bio"]));

                            //Sanitize email
                            $author_email = filter_var($_POST["author_email"], FILTER_SANITIZE_EMAIL);

                            //checking empty fields
                            if(empty($author_name) || empty($author_email) || empty($author_bio)) {
                                echo "Empty Fields";
                            }else {
                                //checking valid email
                                if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
                                    echo "Please enter a valid email";
                                }else {
                                    //to check if password is new
                                    if(empty($author_password)) {
                                        //user dont want to change his password
                                        $author_id = $_SESSION['author_id'];
                                        $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio' WHERE author_id='$author_id';";
                                        if(mysqli_query($conn, $sql)) {
                                           //update the session and recordlive
                                            $_SESSION['author_name'] = $author_name;
                                            $_SESSION['author_email'] = $author_email;
                                            $_SESSION['author_bio'] = $author_bio;
                                            echo "Record Updated Successfully";
                                            exit();
                                    
                                        }else {
                                            echo "Error";
                                        }
                                    }else{
                                        //user wants to change his password
                                        $hashed_author_password = password_hash($author_password, PASSWORD_DEFAULT);
                                        $author_id = $_SESSION['author_id'];
                                        $sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio', author_password='$hashed_author_password' WHERE author_id='$author_id';";
                                        if(mysqli_query($conn, $sql)) {
                                           //update the session and recordlive
                                         
                                            session_unset();
                                            session_destroy();
                                            header("Location: index.php?message=Login+again");
                                            exit();
                                        }
                                    }
                                }
                         
                            }   }
                    ?>
        </div>

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