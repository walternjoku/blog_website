<?php
include_once "../includes/db_connection.php";
include_once "../includes/functions.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: editpage.php?message=Please+Click+the+edit+button");
    exit();
} else {
    if (!isset($_SESSION['author_role'])) {
        header("Location: login.php?message=Please+Login");
        exit();
    } else {
        if ($_SESSION['author_role'] != "admin") {
            echo "Unauthorised Access: DENIED!!";
            exit();
        } else {
            $page_id = $_GET['id'];
            $sql = "SELECT * FROM `page` WHERE page_id='$page_id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) <= 0) {
                // We don't have any page for this ID
                header("Location: page.php?message=No+Page+Found");
                exit();
            }

            // Fetch post data for form
            $formSql = "SELECT * FROM page WHERE page_id=?";
            $stmt = $conn->prepare($formSql);
            $stmt->bind_param('i', $page_id);
            $stmt->execute();
            $formResult = $stmt->get_result();
            if ($formRow = $formResult->fetch_assoc()) {
                $pageTitle = $formRow['page_title'];
                $pageContent = $formRow['page_content'];
            } else {
                $error_message = 'Post not found';
            }
            $stmt->close();

            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $page_title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['page_title']));
                $page_content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['page_content']));

                // Checking empty fields
                if (empty($page_title) || empty($page_content)) {
                    $error_message = 'Please fill in the required fields';
                } else {
                    $updateSql = "UPDATE page SET page_title=?, page_content=? WHERE page_id=?";
                    $stmt = $conn->prepare($updateSql);
                    $stmt->bind_param('ssi', $page_title, $page_content, $page_id);
                    if ($stmt->execute()) {
                        header("Location: page.php?message=Page+Updated");
                        exit();
                    } else {
                        $error_message = 'Error updating the page';
                    }
                    $stmt->close();
                }
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
    <title>Edit Page</title>
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
                    aria-label="Toggle search"></button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation"></button>
            </li>
        </ul>
    </header>
    <?php include_once "sidebar.incl.php" ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Page</h1>
            <h6>Welcome! <?php echo $_SESSION['author_name'] ?> | Your Role is <?php echo $_SESSION['author_role'] ?>
            </h6>
        </div>
        <?php
        if (!empty($error_message)) {
            echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="page_title" class="form-label">Page Title:</label>
                <input type="text" class="form-control" name="page_title" id="page_title" aria-describedby="page_title"
                    placeholder="Enter Page Title" value="<?php echo htmlspecialchars($pageTitle); ?>"><br>
                <label for="page_content">Page Content:</label>
                <textarea class="form-control" rows="5" id="page_content" name="page_content"
                    placeholder="Enter Page Contents"><?php echo htmlspecialchars($pageContent); ?></textarea><br>

            </div>
            <button name="submit" type="submit" class="btn btn-primary">Update</button>
        </form>
    </main>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../style/bootstrap.bundle.min.js"></script>
    <script src="../js/scroll.js"></script>
    <script src="../style/dashboard.js"></script>
</body>

</html>