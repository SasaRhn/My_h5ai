<?php
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/';
    $base_dir = realpath($dir);

    if (file_exists($base_dir) && is_dir($base_dir)) {

        
        $files = scandir($base_dir);

        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Icone</th>
                    <th>Nom</th>
                    <th>Taille</th>
                    <th>Date de dernière modification</th>
                </tr></thead>";
        echo "<tbody>";

        if ($dir !== '/') {
            $parent = dirname($base_dir);
            echo "<tr>
                <td><img src='icon/folder-parent.png' ></td>
                <td><a href='?dir=" . urlencode($parent) . "'>Retour</a></td>
                <td></td>
                <td></td>
                </tr>";
        }

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $base_dir . DIRECTORY_SEPARATOR . $file;
            $relative_path = $dir . '/' . $file;
            $size = '';
            $date = '';
            if (is_dir($path)) {
                $icon = 'folder.png';
            } else {
                $icon = 'file.png';
                $size = filesize($path);
                $file_size = is_file($file_path) ? formatSizeUnits(filesize($file_path)) : '';
                $date = date("d/m/Y H:i:s", filemtime($path));
            }

            echo "<tr>
                <td><img src='icon/$icon'></td><td>";
            if (is_dir($path)) {
                echo "<a href='?dir=" . urlencode($relative_path) . "'>";
            }
            echo htmlspecialchars($file);
            if (is_dir($path)) {
                echo "</a>";
            }
            echo "</td><td>$size</td><td>$date</td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>Le dossier demandé n'existe pas.</p>";
    }
?>
