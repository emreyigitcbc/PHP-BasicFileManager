<?php
include 'func.php';
session_start();
$design->getHeader("File Manager");
$_SESSION[admin_session_name] = true;
?>
<body>
<?php
// CHECKING, IF USER NOT ADMIN.
if ($_SESSION[admin_session_name] != true) {
    header("location: http://google.com");
}
switch ($_GET["st"]) {
    default:
        ?>
	<div id="container">
		<h2 class="center">File Manager | Emre Cebeci</h2>
		<div class="file_listing">
 <?php
        $place = strip_tags($_GET["f"]);
        $fileman->listEverything($place);
        ?>
		</div>
		<form method="post" action="?st=save">
			<input name="file_name" placeholder="DO NOT TOUCH THIS"
				hidden="hidden" value="<?php echo $fileman->getFileName($place); ?>">
			<input name="file_path" placeholder="DO NOT TOUCH THIS"
				hidden="hidden" value="<?php echo $fileman->getFilePath($place); ?>">
<?php $fileman->getButtonTextarea($place);?>
		</form>
	</div>
</body>
<?php
        break;
    case "save":
        $data = $_POST["data"];
        $filename = $_POST["file_name"];
        $filepath = $_POST["file_path"];
        $fileman->saveFile($data, $filepath, $filename);
        echo "<script>alert('You succesfully saved: ".$filename."');</script>";
        header("refresh: 0; url=?f=");
        ?>
<?php
        break;
case "new";
$file = $_POST["new_file"];
$folder = $_POST["new_folder"];
$path = $_POST["file_path"];

if($file != "" && $folder == ""){
   $fileman->create($file, 0, $path, "file");
} else if($file == "" && $folder != ""){
    $fileman->create(0, $folder, $path, "folder");
} else if($file != "" && $folder != ""){
    $fileman->create($file, $folder, $path, "both");
}
echo "<script>alert('You succesfully created: ".$file." ".$folder."');</script>";
header("refresh: 0; url=?f=$path");
break;
case "action";
$x = $_POST["x"];
$r = $_POST["r"];
$filename = $_POST["file_name"];
$path = $_POST["file_path"];
if($x != "" && $r == ""){
    $fileman->remove($path, $x);
    echo "<script>alert('You succesfully removed: ".$x."');</script>";
} else if($x == "" && $r != ""){
    $fileman->renameFile($path, $filename, $r);
    echo "<script>alert('You succesfully renamed to: ".$r."');</script>";
} else {
 return;   
}
header("refresh: 0; url=?f=$path");
break;
}
$design->getFooter();
?>