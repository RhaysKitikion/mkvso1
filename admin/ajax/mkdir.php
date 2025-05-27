<?php
$name=escapeshellcmd($_GET['name']);
//echo $name;
system("mkdir \"$name\"",$status);
if($status==0)
    echo "Директория создана";
    else
    echo "Не удалось создать директорию";

?>