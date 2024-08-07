<?php
include_once "../includes/db_connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
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
            <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

            <div class="form-floating">
                <input type="text" name="author_name" class="form-control" id="floatingInput" placeholder="Enter name">
                <label for="floatingInput">Name</label>
            </div>
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
            <button class="btn btn-primary w-100 py-2" type="submit">Sign Up</button>
        </form>
    </div>
    <?php
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        $author_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['author_name']));
        $author_email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['author_email']));
        $author_password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['author_password']));
        
        //checking for empty fields
        if(empty($author_name) || empty($author_email) || empty($author_password)) {
           header("Location: signup.php?message=Empty+Fields");
           exit();
        }

        // Remove all illegal characters from email
        $author_email = filter_var($author_email, FILTER_SANITIZE_EMAIL);

        //Checking if email is valid
        if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            header("Location: signup.php?message=Please+Enter+A+Valid+Email");
            exit();
        }else{
            //hasing the password
            $hashed_author_password = password_hash($author_password, PASSWORD_DEFAULT);

            //check if email exist
            $sql_query = "SELECT * FROM `author` WHERE `author_email` ='$author_email'";
            
            $result = mysqli_query($conn, $sql_query);

            if(mysqli_num_rows($result) > 0) {
                header("Location: signup.php?message=Email+Already+Exists");
                exit();
            }else{
                //signing up the User
                $sql_query2 = "INSERT INTO `author`(`author_name`, `author_email`, `author_password`, `author_bio`, `author_role`) VALUES ('$author_name', '$author_email', '$hashed_author_password', 'Enter Bio', 'author')";

                if(mysqli_query($conn, $sql_query2)) {
                    header("Location: signup.php?message=Successfully+Registered");
                    exit;
                }else{
                    header("Location: signup.php?message=Registration+FAILED");
                    exit;
                }
            }
            
            
        }
    }
    ?>

    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../style/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
</body>

</html>