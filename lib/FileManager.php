<?php
chdir(ROOT);
error_reporting(E_ERROR);

class FileManager
{

    function listEveryThing($dir)
    {
        include "Settings.php";
        chdir(ROOT);
        if ($dir == "") {
            $dir = ".";
        }

        $filesonly = glob($dir . '/*.{*}', GLOB_BRACE);
        $foldersonly = glob($dir . '/*', GLOB_ONLYDIR);

        echo "<span class='place'>Place: <font color='green'>$dir</font></span>\n<br>";
        if (! file($dir)) {
            echo "<span class='place'>Size: 0KB | Rows: 0</span>\n<hr>";
        } else {
            echo "<span class='place'>Size: " . round(filesize($dir) / 1024, 2) . "KB | Rows: " . count(file($dir)) . "</span>\n<hr>";
        }
        echo "Do not forget to save your changes!<hr>";
        echo "<form method=\"post\" action=\"?st=new\">\n";
        echo "<input name=\"file_path\" placeholder=\"DO NOT TOUCH THIS\"
            hidden=\"hidden\" value=\"" . $dir . "\">";
        echo $this->getMenuArea($dir);
        echo "</form>";
        echo "<hr>\n";
        if ($this->isFile($p)) {
            echo "Choose file or folder:";
        }
        if ((count($foldersonly) || $filesonly) < 1) {
            return;
        }
        echo "<form method=\"post\" action=\"?st=action\">\n";
        echo "<table>\n";
        echo "<input name=\"file_path\" placeholder=\"DO NOT TOUCH THIS\"
            hidden=\"hidden\" value=\"" . $dir . "\">";
        foreach ($foldersonly as $folder) {
            echo "<tr>\n";
            echo "<td><span class='folder'></span><a href='?f=$folder'>" . basename($folder) . "</a></td>\n";
            echo "<td></td>";
            echo "<td>" . $this->getActionButtons($dir, basename($folder)) . "</td>";
            echo "</tr>\n";
        }
        foreach ($filesonly as $file) {
            echo "<tr>\n";
            echo "<td><span class='file'></span><a href='?f=$file'>" . basename($file) . "</a></td>\n";
            echo "<td><span class='size'>" . $this->getInfo($file) . "</span></td>";
            echo "<td>" . $this->getActionButtons($dir, basename($file)) . "</td>";
            echo "</tr>\n";
        }
        echo "</table>\n";
        echo "<span class=\"hidden_babe\"></span>\n";
        echo "<span class=\"hidden_babe2\"></span>\n";
        echo "</form>\n";
    }

    function openFile($p)
    {
        chdir(ROOT);
        if ($p != "") {
            $file = file_get_contents($p);
            return $file;
        }
    }

    function isFile($p)
    {
        return is_file($this->getFilePath($p) . "/" . $this->getFileName($p));
    }

    function getButtonTextarea($p)
    {
        chdir(ROOT);
        if ($p != "") {
            if ($this->isFile($p)) {
                echo "<button type=\"submit\" name=\"buton\">Save</button><br>";
                echo "<textarea class=\"editor\" name=\"data\" placeholder=\"File...\">" . $this->openFile($p) . "</textarea><br>";
                echo "<button type=\"submit\" name=\"buton\">Save</button><br>";
            }
        }
    }

    function getFileName($p)
    {
        chdir(ROOT);
        if ($p != "") {
            $p .= "/";
            $tags = explode("/", $p);
            $sc = count($tags);
            return $tags[$sc - 2];
        }
    }

    function saveFile($data, $filepath, $filename)
    {
        chdir(ROOT);
        $file = fopen($filepath . $filename, "w");
        fwrite($file, $data);
        fclose($file);
        mb_convert_encoding(file($filepath . $filename), "ISO-8859-9");
    }

    function getFilePath($p)
    {
        if ($p != "") {
            $a .= $p . "/";
            $tags = explode("/", $a);
            $sc = count($tags);
            for ($i = 0; $i < $sc - 2; $i ++) {
                $path .= $tags[$i] . "/";
            }
            return $path;
        }
    }

    function create($filename, $foldername, $p, $ffb)
    {
        chdir(ROOT);
        if ($p != "") {
            $path = $p;
            if ($ffb == "folder") {
                chdir($path);
                mkdir($foldername);
            } else if ($ffb == "file") {
                if (strpos($filename, '.') !== false) {
                    chdir($path);
                    $f = fopen($filename, "w");
                    fwrite($f, "");
                    fclose($f);
                } else {
                    echo "<script>alert(\"We do not support sessile files.\");</script>";
                }
            } else if ($ffb == "both") {
                chdir($path);
                $this->create(0, $foldername, $p, "folder");
                $this->create($filename, 0, $p, "file");
            } else {
                return;
            }
        }
    }

    function getMenuArea($p)
    {
        $placex = explode("/", $p);
        $placex_count = count($placex);
        for ($i = 0; $i < $placex_count - 1; $i ++) {
            if ($i == $placex_count - 2) {
                $upfolder .= $placex[$i];
            } else {
                $upfolder .= $placex[$i] . "/";
            }
        }
        if ($this->isFile($p)) {
            echo "<a href='?f=$upfolder' id=\"up\">UP</a>\n";
        } else {
            echo "<a href='?f=$upfolder' id=\"up\">UP</a> | <a id=\"new_folder\" onclick=\"newFileFolder('folder')\">New Folder</a> | <a id=\"new_file\" onclick=\"newFileFolder('file')\">New File</a>\n";
        }
    }

    function getInfo($p)
    {
        $size = round(filesize($p) / 1024, 2);
        $rows = count(file($p));
        return $size . "KB / Rows: " . $rows;
    }

    function getActionButtons($p, $name)
    {
        $plaintext = "<button class=\"ab\" type=\"submit\" name=\"x\" value=\"$name\">X</button> <input type=\"button\" class=\"ab\" name=\"r-$name\" onclick=\"renameButton('r-$name'); showButtons('$name')\" value=\"R\"></input>";
        return $plaintext;
    }

    function remove($p, $name)
    {
        if ($this->isFile($p . "/" . $name)) {
            chdir($p);
            unlink($name);
        } else {
            chdir($p);
            rmdir($name);
        }
    }

    function renameFile($p, $old_name, $new_name)
    {
        chdir($p);
        if ($this->isFile($p.$old_name)) {
            $c = explode(".", $new_name);
            if(count($c) >= 1){
                if (file_exists($new_name)) {
                    echo "Error While Renaming $old_name";
                } else {
                    if (rename($old_name, $new_name)) {
                        echo "Successfully Renamed $old_name to $new_name";
                    } else {
                        echo "A File With The Same Name Already Exists";
                    }
                }
            } else {
                echo "no";
            }
        } else {
            if (file_exists($new_name)) {
                echo "Error While Renaming $old_name";
            } else {
                if (rename($old_name, $new_name)) {
                    echo "Successfully Renamed $old_name to $new_name";
                } else {
                    echo "A File With The Same Name Already Exists";
                }
            }
        }
    }
}
?>