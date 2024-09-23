<?php
if (isset($_GET["folder_name"])) {
    $folder_name = $_GET["folder_name"];
    // echo $folder_name;
    rmdir($folder_name);
    header("Location:script.php");
}
