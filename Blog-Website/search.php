<?php
include_once "includes/db_connection.php";

if(!isset($_GET['s'])){
    header("Location: index.php");
    exit();
}else{
    $search = mysqli_real_escape_string($conn, $_GET['s']);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <!--NAVIGATION BAR HERE -->
    <?php include_once "includes/nav.php";?>
    <!--LIGHT BAR HERE -->
    <?php include_once "includes/light_nav_bar.php";?>

    <div class="container mt-3">
        <h1>Showing All Results for &nbsp;<?php echo $search ?></h1>
        <div class="row">
            <?php
                 $sql = "SELECT * FROM `post` WHERE `post_title` LIKE '%$search%' OR `post_content` LIKE '%$search%' OR `post_keywords` LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) <= 0){
                    echo "<h2>Not Result Found</h2>";
                    exit();
                }
        
                while($row = mysqli_fetch_assoc($result)) {
                    $post_title = $row['post_title'];
                    $post_image = $row['post_image'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_id = $row['post_id'];
        
                $sql_author = "SELECT * FROM `author` WHERE author_id ='$post_author'";
                $result_author = mysqli_query($conn, $sql_author);
                while($author_row = mysqli_fetch_assoc($result_author)) {
                $post_author_name = $author_row['author_name'];
            ?>
            <!--<div class="card" style="width: 18rem;">-->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $post_image?>" class="card-img-top" alt="cardimage">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post_title?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $post_author_name?></h6>
                        <p class="card-text"><?php echo substr($post_content, 0, 20)."...";?></p>
                        <a href="readpost.php?id=<?php echo $post_id; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php }}?>
        </div>
    </div>


    <script src=" js/jquery-3.7.1.min.js"></script>
    <script src="style/bootstrap.bundle.min.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>
<?php
}
?>