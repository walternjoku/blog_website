<?php
include_once "includes/db_connection.php";
include_once "includes/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walt Blog</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/bootstrap.min.css">
</head>

<body>
    <!--NAVIGATION BAR HERE -->
    <?php include_once "includes/nav.php";?>
    <!--LIGHT BAR HERE -->
    <?php include_once "includes/light_nav_bar.php";?>

    <div class="container mt-3">
        <?php
    //pagination
    $sqlpg = "SELECT * FROM `post`";
    $resultpg = mysqli_query($conn, $sqlpg);
    $totalpost = mysqli_num_rows($resultpg);
    $totalpages = ceil($totalpost/6);
    
    ?>
        <?php
    //getting pagination
    if(isset($_GET['p'])){
        $pageid = $_GET['p'];
        $start = ceil($pageid * 6)-6;
        $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT $start, 6";
    } else{
        $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT 0, 6";
    }
    
    ?>
        <div class="row">
            <?php
                
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
        <div class="paginationCentering">
            <?php
            //centering the pagination buttons
            //to run a loop for the pagination
            for($i = 1; $i <= $totalpages; $i++ ){
                ?>
            <a href="?p=<?php echo $i; ?>"><button class="btn btn-info"><?php echo $i; ?></button></a> &nbsp;
            <?php
            }
            ?>
        </div>
    </div>
    <br><br>


    <script src=" js/jquery-3.7.1.min.js"></script>
    <script src="style/bootstrap.bundle.min.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>