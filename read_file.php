<?php
if (isset($_GET["file_name"])) {
    $file_name = $_GET["file_name"];
    // echo $file_name;
    $f = fopen($file_name, "r");
    echo fgets($f);
    fclose($f);
}
