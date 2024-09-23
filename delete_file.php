<?php
if (isset($_GET["file_name"])) {
    $file_name = $_GET["file_name"];
    // echo $file_name;
    unlink($file_name);
    header("Location:script.php");
}
