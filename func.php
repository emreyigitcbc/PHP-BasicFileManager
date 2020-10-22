<?php 
ob_start();
header("Content-type: text/html; charset=iso-8859-9");
include "lib/settings.php";
include "lib/Design.php";
include "lib/FileManager.php";

$design = new Design;
$fileman = new FileManager;
?>