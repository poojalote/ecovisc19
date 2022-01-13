<?php
$content = $_GET["content"];
$file = "new_page".uniqid() . ".php";
file_put_contents($file, $content);
echo $file;
?>