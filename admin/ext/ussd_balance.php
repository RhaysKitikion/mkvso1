<?php
include("../config.php");
$oper=$_GET['oper'];
echo $operators[$oper]['ussd_balance'];

?>