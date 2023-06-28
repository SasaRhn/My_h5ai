<?php
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/';
    $direction = realpath($dir);

    function TailleFormat($bytes)
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
    echo "<p>Chemin : " . $direction . "</p>";
    echo "</ul>";

    if (file_exists($direction) && is_dir($direction)) {
        $fichier = scandir($direction);
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
            $parent = dirname($direction);
            echo "<tr>
                    <td><img src='icon/folder-parent.png' ></td>
                    <td><a href='?dir=" . urlencode($parent) . "'>Retour</a></td>
                    <td></td>
                    <td></td>
                </tr>";
        }
        foreach ($fichier as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $direction . DIRECTORY_SEPARATOR . $file;
            $selection = $dir . '/' . $file;
            if (is_dir($path)) {
                $icon = 'folder.png';
            } else {
                $icon = 'file.png';
            }
            $fichier_selectioner = $direction . '/' . $file;
            $selection = $dir . '/' . $file;
            $tailledufichierajour = is_file($fichier_selectioner) ? TailleFormat(filesize($fichier_selectioner)) : '';
            $date_modifier = date("Y-m-d H:i:s", filemtime($fichier_selectioner));

            echo "<tr>
                <td><img src='icon/$icon'></td><td>";
            if (is_dir($path)) {
                echo "<a href='?dir=" . urlencode($selection) . "'>";
            }
            echo htmlspecialchars($file);
            if (is_dir($path)) {
                echo "</a>";
            }
            echo "</td><td>$tailledufichierajour</td><td>$date_modifier</td></tr>";
        }

        echo "</body>
            </table>";
    } else {
        echo "<p>Le dossier demandé n'existe pas.</p>";
    }
?>
