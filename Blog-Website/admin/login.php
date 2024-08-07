<?php
session_start();
include_once "../includes/db_connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/styles.css">
</head>

<body>
    <?php
        if(isset($_GET['message'])) {
            $message = $_GET['message'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    ?>

    <div id="form-style">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Please Login</h1>

            <div class="form-floating">
                <input type="email" name="author_email" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="author_password" class="form-control" id="floatingPassword"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
        </form>
    </div>
    <?php
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        $author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
        $author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
        
        //checking for empty fields
        if(empty($author_email) || empty($author_password)) {
           header("Location: login.php?message=Empty+Fields");
           exit();
        }

        // Remove all illegal characters from email
        $author_email = filter_var($author_email, FILTER_SANITIZE_EMAIL);

        //Checking if email is valid
        if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            header("Location: login.php?message=Please+Enter+A+Valid+Email");
            exit();
        }else{
            //hasing the password
            //$hashed_author_password = password_hash($author_password, PASSWORD_DEFAULT);

            //check if email exist
            $sql_query = "SELECT * FROM `author` WHERE `author_email` = '$author_email'";
            
            $result = mysqli_query($conn, $sql_query);

            if(mysqli_num_rows($result) <= 0) {
                header("Location: login.php?message=Wrong+Email");
                exit;
            }else {
                while($row = mysqli_fetch_assoc($result)) {
                    
                    //checking if password matches
                    if (!password_verify($author_password, $row['author_password'])) {
                        // Password is incorrect
                        header("Location: login.php?message=Wrong+Password");
                        exit();

                    } else if (password_verify($author_password, $row['author_password'])) {
                        
                        $_SESSION['author_id'] = $row['author_id'];
                        $_SESSION['author_name'] = $row['author_name'];
                        $_SESSION['author_email'] = $row['author_email'];
                        $_SESSION['author_bio'] = $row['author_bio'];
                        $_SESSION['author_role'] = $row['author_role'];
                        header("Location: index.php");
                        exit();
                }
            }}

        }
    }
    ?>

    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../style/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
</body>

</html>