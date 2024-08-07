<?php
include_once "includes/db_connection.php";
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-black text-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Walters Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                    $sqlpage = "SELECT * FROM page";
                    $resultpage = mysqli_query($conn, $sqlpage);
                    while($rowpage = mysqli_fetch_array($resultpage)) {
                        $page_id = $rowpage['page_id'];
                        $page_title = $rowpage['page_title'];

                ?>
                <li class="nav-item">
                    <a class="nav-link" href="clientpage.php?id=<?php echo $page_id; ?>"><?php echo $page_title; ?></a>
                </li>
                <?php
                    }
                ?>

                <li class=" nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        All Categories
                    </a>

                    <ul class="dropdown-menu">
                        <?php
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)) {
                            $category_id = $row['category_id'];
                            $category_name = $row['category_name'];

                            ?>
                        <li><a class="dropdown-item"
                                href="category.php?=id=<?php echo $category_id ?>"><?php echo $category_name; ?></a>
                        </li>
                        <?php
                        }
                    ?>


                    </ul>
                </li>
            </ul>
            <form action="search.php" class="d-flex" role="search">
                <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>