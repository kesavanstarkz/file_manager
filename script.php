<?php
$dir_path = "directory";

if (!is_dir($dir_path)) {
    mkdir($dir_path);
}


$files = scandir($dir_path);

if (isset($_POST["create_file"]) && isset($_POST["input_data"]) && isset($_POST["selected_option"])) {
    $input_data = htmlspecialchars(trim($_POST["input_data"]));
    $selected_option = htmlspecialchars(trim($_POST["selected_option"]));
    try {
        $file_path = ($selected_option === '') ? $dir_path . "/" . $input_data : $dir_path . "/" . $selected_option . "/" . $input_data;

        if (!file_exists($file_path)) {

            fopen($file_path, "wb");
            header("Location: script.php");
            exit;
        } else {
            echo "<div class='alert alert-warning'>File named '$input_data' already exists.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
    }
}

if (isset($_POST["create_folder"]) && isset($_POST["input_data"])) {
    $input_data = htmlspecialchars(trim($_POST["input_data"]));
    try {
        $folder_path = $dir_path . "/" . $input_data;

        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
            header("Location: script.php");
            exit;
        } else {
            echo "<div class='alert alert-warning'>Folder named '$input_data' already exists.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
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
        <div class="d-flex justify-content-around mb-3">
            <div class="h1 text-success">FILE MANAGER</div>
            <div class="align-self-center">
                <form class="d-flex" action="script.php" method="POST">

                    <div class="dropdown px-5">
                        <button type="button" class="btn btn-transparent text-success dropdown-toggle" data-bs-toggle="dropdown">
                            Create
                        </button>
                        <ul class="dropdown-menu p-4">
                            <li>
                                <input type="text" class="form-control" name="input_data" placeholder="Enter name" required>
                                <div class="dropdown-header text-success">Create File</div>
                                <form method="POST" class="d-flex">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="selected_option" id="no-folder" value="" required>
                                        <label class="form-check-label" for="no-folder">No Folder (Create in main directory)</label>
                                    </div>
                                    <?php
                                    if ($handle = opendir($dir_path)) {
                                        while (false !== ($entry = readdir($handle))) {
                                            if ($entry !== "." && $entry !== ".." && is_dir("$dir_path/$entry")) {
                                                echo "<div class='form-check'>";
                                                echo "<input type='radio' class='form-check-input' name='selected_option' id='$entry' value='$entry' required>";
                                                echo "<label class='form-check-label' for='$entry'>$entry</label>";
                                                echo "</div>";
                                            }
                                        }
                                        closedir($handle);
                                    }
                                    ?>
                                    <button type="submit" name="create_file" class="btn btn-transparent text-success mt-2">Create File</button>
                                </form>


                            </li>
                            <form method="POST" class="mt-2">
                                <input type="text" class="form-control mb-2" name="input_data" placeholder="Enter folder name" required>
                                <button type="submit" name="create_folder" class="btn btn-transparent text-success">Create Folder</button>
                            </form>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-dark table-hover text-center">
            <thead>
                <tr>
                    <th>File/Folder</th>
                    <th>Date Created</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($files as $file) {
                    if ($file !== "." && $file !== "..") {
                        $file_path = $dir_path . "/" . $file;
                        echo "<tr>";
                        echo "<td>$file</td>";
                        echo "<td>" . date("Y-m-d H:i:s", filemtime($file_path)) . "</td>";
                        echo "<td>" . (is_file($file_path) ? round(filesize($file_path) / 1024, 2) . " KB" : "N/A") . "</td>";
                        echo "<td>";
                        if (is_file($file_path)) {
                            echo "<a href='delete_file.php?file_name=$file_path' class='text-danger'>Delete</a> | ";
                            echo "<a href='read_file.php?file_name=$file_path' class='text-success'>Read</a> | ";
                            echo "<a href='edit_file.php?file_name=$file_path' class='text-info'>Edit</a>";
                        } else {
                            echo "<a href='delete_folder.php?folder_name=$file_path' class='text-danger'>Delete Folder</a> | <a href='view_folder.php?folder_name=$file_path' class='text-success'>View Folder</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>