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
$page_id = $_GET['id'];
$sql = "DELETE FROM `page` WHERE `page_id`='$page_id'";
if(mysqli_query($conn, $sql)){
    header("Location: page.php?message=Page+Delected");
    exit();
}else{
    header("Location: page.php?message=Unable+to+Delect+Page");
    exit();
}