<?php
//print_r($_REQUEST);
$file=$_GET['name'];
$content=stripslashes($_POST['editor']);
if(file_put_contents($file,$content))
    {
//    print_r($_SERVER['QUERY_STRING']);
//    $url=
    header("Location: /admin/service.php?".$_SERVER['QUERY_STRING']."&save_file=".urlencode("Файл успешно сохранен"));
    }
    else
    {
    header("Location: /admin/service.php?".$_SERVER['QUERY_STRING']."&save_file=".urlencode("Не удалось сохранить файл"));
    }
?>