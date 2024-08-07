<?php 
include_once "../includes/db_connection.php";
session_start();

if(!isset($_POST['submit'])) {
    header("Location: categories.php?message=Please+Add+a+Category");
    exit();
}else {
    if(!isset($_SESSION['author_role'])) {
        header("Location: login.php");
    }else {
        if($_SESSION['author_role'] != "admin"){
            echo "You can't access this page";
            exit();
        }elseif($_SESSION['author_role'] == "admin"){
            $category_name = $_POST['category_name'];
            $sql = "INSERT INTO category(`category_name`) VALUES('$category_name');";
            if(mysqli_query($conn, $sql)) {
                header("Location: categories.php?message=Added");
                exit();
            }else{
                header("Location: categories.php?message=Error+Adding");
                exit();
            }
        }
    }
}