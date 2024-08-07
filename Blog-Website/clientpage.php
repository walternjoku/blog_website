<?php
include_once "includes/db_connection.php";
include_once "includes/functions.php";

if(!isset($_GET['id'])) {
    header("Location: index.php");
} else {
    $id = mysqli_real_escape_string($conn, htmlspecialchars($_GET['id']));
    if(!is_numeric($id)) {
        header("Location: index.php");
        exit();
    } elseif(is_numeric($id)) {
        $sql = "SELECT * FROM page WHERE page_id='$id'";
        $result = mysqli_query($conn, $sql);
        //checks if page exists
        if(mysqli_num_rows($result) <= 0) {
            //no posts
            header("Location: index.php?message=No+Page+Found");
        } elseif(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $page_title = $row['page_title'];
                $page_content = $row['page_content'];
                $page_title2 = $row['page_title'];
              
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title;?></title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <!--NAVIGATION BAR HERE -->
    <?php include_once "includes/nav.php";?>
    <!--LIGHT BAR HERE -->
    <?php include_once "includes/light_nav_bar.php";?>


    <div class="container mt-3">
        <h1
            style="width:100%; background-color:grey; padding-top:25px; padding-bottom:25px; text-align:center; color:white;">
            <?php echo $page_title2;?>
        </h1>
        <hr>
        <p><?php echo $page_content;?></p>
    </div>


    <script src=" js/jquery-3.7.1.min.js"></script>
    <script src="style/bootstrap.bundle.min.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>