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
    <title>Posts</title>
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
            <h1 class="h2">Posts</h1>
            <h6>Welcome! <?php echo $_SESSION['author_name']?> | Your Role is
                <?php echo $_SESSION['author_role']?> </h6>
        </div>
        <h1>ALL POSTS:</h1>
        <a href="newpost.php"><button type="button" class="btn btn-info">Add New</button></a>
        <hr>
        <table class="table">
            <thead>
                <th scope="col">Post Id</th>
                <th scope="col">Post Image</th>
                <th scope="col">Post Title</th>
                <th scope="col">Post Author</th>
                <?php if ($_SESSION['author_role'] === "admin") {?>
                <th scope="col">Action</th>
                <?php }?>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <?php
            $sql = "SELECT * FROM `post` ORDER BY post_id DESC";
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
            <tr>
                <th scope="row"><?php echo $post_id;?></th>
                <td><img src="../<?php echo $post_image;?>" width="70px" height="70px"></td>
                <td><?php echo $post_title;?></td>
                <td><?php echo $post_author_name;?></td>
                <?php if ($_SESSION['author_role'] === "admin") {?>
                <td><a href="editpost.php?id=<?php echo $post_id;?>"><button class="btn btn-info">Edit</button></a>
                    <a onclick="return confirm('Are you sure');" href="deletepost.php?id=<?php echo $post_id;?>"><button
                            class="btn btn-danger">Delete</button></a>
                </td>
                <?php }?>
            </tr>


            <?php }}?>
        </table>
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