<?php
include_once "db_connection.php";


function getAuthorName($id) {
    global $conn;
    $sql = "SELECT * FROM author WHERE author_id='$id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['author_name'];
        echo $name;
    }
}

function getCategoryName($id) {
    global $conn;
    $sql = "SELECT * FROM category WHERE category_id='$id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['category_name'];
        echo $name;
    }
}

/*
function getSettingValue($setting){
    global $conn;
    $sql = "SELECT * FROM `settings` WHERE `setting_name` = '$setting'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $value = $row['setting_value'];
        echo $value;
    }
}
*/
function getSettingValue($setting_name) {
    global $conn;
    $sql = "SELECT setting_value FROM settings WHERE setting_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $setting_name);
    $stmt->execute();
    $stmt->bind_result($value);
    $stmt->fetch();
    $stmt->close();
    
    return $value;
}

function setSettingValue($setting_name, $value){
    global $conn;
    $sql = "Update settings SET setting_value='$value' WHERE setting_name='$setting_name'";
    if(mysqli_query($conn, $sql)){
        return true;;
    }else{
        return false;
    }
}