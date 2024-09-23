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
        <table class="table table-dark table-hover text-center">
            <thead>
                <tr>
                    <th>File/Folder</th>
                    <th>Date Modified</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET["folder_name"])) {
                    $folder_name = $_GET["folder_name"];
                    $myfiles = scandir($folder_name);

                    foreach ($myfiles as $file) {
                        if ($file !== "." && $file !== "..") {
                            $file_path = $folder_name . "/" . $file;
                            echo "<tr>";
                            echo "<td>$file</td>";
                            echo "<td>" . date("Y-m-d H:i:s", filemtime($file_path)) . "</td>";
                            echo "<td>" . (is_file($file_path) ? round(filesize($file_path) / 1024, 2) . " KB" : "N/A") . "</td>";
                            echo "<td>";
                            if (is_file($file_path)) {
                                echo "<a href='delete_file.php?file_name=" . urlencode($file_path) . "' class='text-danger'>Delete</a> | ";
                                echo "<a href='read_file.php?file_name=" . urlencode($file_path) . "' class='text-success'>Read</a> | ";
                                echo "<a href='edit_file.php?file_name=" . urlencode($file_path) . "' class='text-info'>Edit</a>";
                            } else {
                                echo "<a href='delete_folder.php?folder_name=" . urlencode($file_path) . "' class='text-danger'>Delete Folder</a> | ";
                                echo "<a href='view_folder.php?folder_name=" . urlencode($file_path) . "' class='text-success'>View Folder</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>