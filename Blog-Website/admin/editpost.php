<?php
include_once "../includes/db_connection.php";
session_start();

$error_message = '';

if (isset($_SESSION['author_role']) && ($_SESSION['author_role'] === 'admin')) {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Working on submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $post_id = $_GET['id'];
        $post_title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['post_title']));
        $post_content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['post_content']));
        $post_keywords = mysqli_real_escape_string($conn, htmlspecialchars($_POST['post_keywords']));

        // Checking empty fields
        if (empty($post_title) || empty($post_content)) {
            $error_message = 'Please fill in the required fields';
        } else {
            $file_uploaded = false;
            if (isset($_FILES['myFile']) && is_uploaded_file($_FILES['myFile']['tmp_name'])) {
                $file = $_FILES["myFile"];
                $fileName = $file["name"];
                $fileType = $file["type"];
                $fileTmp = $file["tmp_name"];
                $fileErr = $file["error"];
                $fileSize = $file["size"];

                $fileExt = explode(".", $fileName);
                $allowedExt = array("jpg", "jpeg", "png", "gif");

                $fileExtension = strtolower(end($fileExt));

                if (in_array($fileExtension, $allowedExt)) {
                    if ($fileErr === 0) {
                        if ($fileSize < 5000000) {
                            $newFileName = uniqid("", true) . "." . $fileExtension;
                            $destination = "../uploads/" . $newFileName;
                            $db_destination = "uploads/$newFileName";
                            if (move_uploaded_file($fileTmp, $destination)) {
                                $file_uploaded = true;
                            } else {
                                $error_message = 'Error moving uploaded file';
                            }
                        } else {
                            $error_message = 'Your file size is too big';
                        }
                    } else {
                        $error_message = 'Error uploading your file';
                    }
                } else {
                    $error_message = 'Wrong file format';
                }
            }

            if (empty($error_message)) {
                if ($file_uploaded) {
                    $sql = "UPDATE post SET post_title=?, post_keywords=?, post_content=?, post_image=? WHERE post_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssssi', $post_title, $post_keywords, $post_content, $db_destination, $post_id);
                } else {
                    $sql = "UPDATE post SET post_title=?, post_keywords=?, post_content=? WHERE post_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sssi', $post_title, $post_keywords, $post_content, $post_id);
                }
                
                if ($stmt->execute()) {
                    header("Location: post.php?message=Post+Updated");
                    exit();
                } else {
                    $error_message = 'Error uploading post';
                }
                $stmt->close();
            }
        }
    }

    // Fetch post data for form
    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];
        $formSql = "SELECT * FROM post WHERE post_id=?";
        $stmt = $conn->prepare($formSql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $formResult = $stmt->get_result();
        if ($formRow = $formResult->fetch_assoc()) {
            $postTitle = $formRow['post_title'];
            $postContent = $formRow['post_content'];
            $postImage = $formRow['post_image'];
            $postKeywords = $formRow['post_keywords'];
        } else {
            $error_message = 'Post not found';
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
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
            <h1 class="h2">Edit Post</h1>
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
                <label for="post_title" class="form-label">Post Title:</label>
                <input type="text" class="form-control" name="post_title" id="post_title" aria-describedby="post_title"
                    placeholder="Enter Post Title" value="<?php echo htmlspecialchars($postTitle); ?>"><br>
                <label for="post_content">Post Content:</label>
                <textarea class="form-control" rows="5" id="post_content" name="post_content"
                    placeholder="Enter Post Contents"><?php echo htmlspecialchars($postContent); ?></textarea><br>
                <img src="../<?php echo htmlspecialchars($postImage); ?>" width="150px" height="150px"><br>
                <label for="post_image" class="form-label">Post Image:</label>
                <input class="form-control" type="file" name="myFile" id="post_image"><br>
                <label for="post_keywords" class="form-label">Post Keywords:</label>
                <input type="text" class="form-control" name="post_keywords" id="post_keywords"
                    aria-describedby="post_keywords" placeholder="Enter Post Keywords"
                    value="<?php echo htmlspecialchars($postKeywords); ?>">
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
<?php
} else {
    header("Location: login.php?message=Please+Login");
    exit();
}
?>