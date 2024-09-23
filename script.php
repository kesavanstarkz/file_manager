<?php

// $directory = mkdir("directory");
$dir_path = "directory";
$files = scandir($dir_path);


if (isset($_POST["create_file"])) {
    $input_data = htmlspecialchars($_POST["input_data"]);
    try {
        $file_path = $dir_path . "/" . $input_data;

        if (!file_exists($file_path)) {
            fopen($file_path, "wb");
            header("Location:script.php");
        } else {
            echo "file named $input_data already exists";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


if (isset($_POST["create_folder"])) {
    $input_data = htmlspecialchars($_POST["input_data"]);
    try {
        $folder_path = $dir_path . "/" . $input_data;
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
            header("Location:script.php");
        } else {
            echo "Folder named $input_data already exists";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>File Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


    <div class="container mt-3">
        <div class="d-flex justify-content-around  mb-3">
            <div class="h1 text-success">FILE MANAGER</div>
            <div class="align-self-center ">
                <form class="d-flex" action="script.php" method="POST">
                    <input type="text" class="form-control" name="input_data" placeholder="Enter name">

                    <div class="dropdown">

                        <button type="submit" class="btn btn-transparent text-success dropdown-toggle" data-bs-toggle="dropdown">
                            Create
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="submit" class="btn btn-transparent text-success dropdown-item" name="create_file">
                                    Create File
                                </button>
                                <button type="submit" class="btn btn-transparent text-success dropdown-item" name="create_folder">
                                    Create Folder
                                </button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-dark table-hover text-center">
            <thead>
                <tr>
                    <th>Folder</th>
                    <th>Date Created</th>
                    <th>Size</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($files as $file) {
                    $file_path = $dir_path . "/" . $file;
                    $total_path = $dir_path . "/" . $file;
                    if (is_file($file_path)) {
                        echo "<tr>";
                        echo "<td>$total_path</td>";
                        echo "<td>" . date("Y-m-d H:i:s", filemtime($file_path)) . "</td>";
                        echo "<td>" . round(filesize($file_path) / 1024, 2) . " KB</td>";
                        echo "</tr>";
                    }
                }

                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
<?php

?>