<?php
include_once "../includes/db_connection.php";
session_start();
if(!isset($_GET['id'])) {
    header("Location: index.php");
}else{
    //chech if user is admin
    if(!isset($_SESSION['author_role'])) {
        header("Location: login.php?message=Please+login");
    }else {
        if($_SESSION['author_role']!= "admin") {
            echo "ERROR: You cannot access this page";
            exit();
        }elseif($_SESSION['author_role'] == "admin") {
            $id = $_GET['id'];

            $sqlCheck = "SELECT * FROM post WHERE post_id='$id'";
            $result = mysqli_query($conn, $sqlCheck);
            if(mysqli_num_rows($result) <= 0){
                header("Location: post.php?message=No+File");
                exit();
            }

            $sql = "DELETE FROM post WHERE post_id='$id'";
            if(mysqli_query($conn, $sql)) {
                header("Location: post.php?message=Successfully+Deleted");
                exit();
            }else{
                header("Location: post.php?message=Unable to Delete Post");
            }
        }
    }
}