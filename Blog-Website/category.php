<?php
include_once "includes/db_connection.php";
include_once "includes/light_nav_bar.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
} else {
    $id = mysqli_real_escape_string($conn, htmlspecialchars($_GET['id']));
    if (!is_numeric($id)) {
        header("Location: index.php");
        exit();
    } elseif (is_numeric($id)) {
        $sql = "SELECT * FROM category WHERE category_id='$id'";
        $result = mysqli_query($conn, $sql);
        //checks if category exists
        if (mysqli_num_rows($result) <= 0) {
            //no category
            header("Location: index.php?message=No+Result");
        } else {
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



    <div class="container mt-3">
        <h1 id="categoryStyle">Showing All Posts for Category: <?php getCategoryName($id); ?></h1>
        <div class="row">
            <?php
                $sql = "SELECT * FROM `post` WHERE post_category = '$id' ORDER BY post_id DESC";
                $result = mysqli_query($conn, $sql);
        
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
    }
}
?>