<?php
//echo $_GET['name'];

if(file_exists($_GET['name']))
    $str=file_get_contents($_GET['name']);
    else
    $str="Файл не существует";
echo $str;
?>