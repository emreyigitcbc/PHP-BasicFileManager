<?php 
class Design{
    function getHeader($title){
        include 'Settings.php';
        echo "<html>\n";
        echo "<head>\n";
        echo "<title>$title</title>\n";
        echo "<meta name=\"author\" content=\"$m_author\">\n";
        echo "<meta name=\"description\" content=\"$m_description\">\n";
        echo "<meta http-equiv='viewport' content='width=device-width, height=device-height, user-scalable=yes'>\n";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".FM_ROOT."default.css\">\n";
        echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>";
        echo "<script src=\"".FM_ROOT."lib/FManager.js\"></script>";
        echo "</head>\n";
    }
    function getFooter(){
        
    }
}
?>