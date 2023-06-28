<?php
        function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function getFileIcon($file)
    {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'html':
                return 'https://www.example.com/icons/html.png';
            case 'txt':
                return 'https://www.example.com/icons/txt.png';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'https://www.example.com/icons/image.png';
            case 'pdf':
                return 'https://www.example.com/icons/pdf.png';
            default:
                return 'https://www.example.com/icons/default.png';
        }
    }

    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/';
    $base_dir = realpath($dir);

    if (file_exists($base_dir) && is_dir($base_dir)) {
        $files = scandir($base_dir);

        echo "<p>Chemin d'accès : " . htmlspecialchars($base_dir) . "</p>";

        echo "<table>";
        echo "<tr>";
        echo "<th>Icon</th>";
        echo "<th>Nom</th>";
        echo "<th>Taille</th>";
        echo "<th>Date de modification</th>";
        echo "</tr>";

        if ($dir !== '/') {
            $parent = dirname($base_dir);
            echo "<tr>";
            echo "<td></td>";
            echo "<td><a href='index.php/" . ltrim(urlencode($parent), '/') . "'>.. (Dossier parent)</a></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "</tr>";
        }}

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $file_path = $base_dir . '/' . $file;
            $relative_path = $dir . '/' . $file;

            $icon = getFileIcon($file_path);
            $file_size = is_file($file_path) ? formatSizeUnits(filesize($file_path)) : '';
            $modified_time = date("Y-m-d H:i:s", filemtime($file_path));

            echo "<tr>";
            echo "<td><img src='" . $icon . "' class='file-icon' /></td>";
            echo "<td>";

            if (is_dir($file_path)) {
                echo "<a href='index.php" . urlencode($relative_path) . "'>" . htmlspecialchars($file) . "</a>";
            } else {
                echo htmlspecialchars($file);
            }

            echo "</td>";
            echo "<td>" . $file_size . "</td>";
            echo "<td>" . $modified_time . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    ?>