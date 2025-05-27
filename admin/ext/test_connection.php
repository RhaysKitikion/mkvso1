<?php
$ch=curl_init($_POST['url']);
ob_start();
curl_setopt($ch,CURLOPT_POSTFIELDS,$_POST['data']);
curl_setopt($ch,CURLOPT_TIMEOUT,30);
curl_exec($ch);
$str=ob_get_contents();
ob_clean();
ob_end_flush();
$res=curl_getinfo($ch);
$err_str=curl_error($ch);
$err=curl_errno($ch);
curl_close($ch);
if($err!=0)
echo "<font color=red>Произошла ошибка: код $err &lt;$err_str&gt;</font>" ;
else
echo "<font color=green>Запрос успешно выполнен за ".$res['total_time']." сек.</font>"; 
?>