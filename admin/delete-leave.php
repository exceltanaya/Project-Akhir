<?php
require_once "../connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM emp_leave WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: manage-leave.php?delete-successfully");
    } else {
        header("Location: manage-leave.php?delete-failed");
    }
} else {
    header("Location: manage-leave.php");
}
