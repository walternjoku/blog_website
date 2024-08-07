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
        $sql = "SELECT * FROM post WHERE post_id='$id'";
        $result = mysqli_query($conn, $sql); 
        //checks if post exists 
        if(mysqli_num_rows($result) <= 0) { 
            //no posts
            header("Location: index.php?message=No+Result"); 
        } elseif(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $post_title = $row['post_title'];
                $post_content = $row['post_content'];
                $post_category = $row['post_category'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_keywords = $row['post_keywords'];
                $post_image = $row['post_image'];
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
    <title><?php echo $post_title;?></title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <!--NAVIGATION BAR HERE -->
    <?php include_once "includes/nav.php";?>
    <!--LIGHT BAR HERE -->
    <?php include_once "includes/light_nav_bar.php";?>


    <div class="container mt-3">
        <img style="width: 100%;" src="<?php echo $post_image;?>">
        <h1><?php echo $post_title;?></h1>
        <hr>
        <h6>Posted On: <?php echo $post_date;?> | By <?php getAuthorName($post_author);?> </h6>
        <h4>Category: <a href="category.php?id=<?php echo $post_category ?>">
                <?php getCategoryName($post_category); ?></a></h4>
        <p><?php echo $post_content;?></p>
    </div>


    <script src=" js/jquery-3.7.1.min.js"></script>
    <script src="style/bootstrap.bundle.min.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>