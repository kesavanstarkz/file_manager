<?php
if (isset($_GET["file_name"])) {
    if (isset($_POST['submit'])) {
        $file_name = $_GET["file_name"];
        $f = fopen($file_name, "a");
        fwrite($f, $_POST['text']);
        header("Location:script.php");
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    <div class="container mt-3">
        <form action="" method="post">
            <label for="text">Enter Text:</label>
            <textarea class="form-control" rows="5" id="text" name="text"></textarea>
            <button type="submit" name="submit" class="btn btn-transparent text-success">Submit Data</button>
        </form>

    </div>
</body>

</html>