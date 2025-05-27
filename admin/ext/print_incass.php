<?php
include ("../classes/db.php");
$db = new DB('/var/lib/kiosk/kiosk.db');;//'../../user/kiosk.db');
$dt1=$_GET['dt1'];
$dt2=$_GET['dt2'];
$t1=mktime(0,0,0,substr($dt1,3,2),substr($dt1,0,2),substr($dt1,6,4));
$t2=mktime(24,0,0,substr($dt2,3,2),substr($dt2,0,2),substr($dt2,6,4));
$query="SELECT * FROM cash_collections WHERE cash_collection_timestamp between $t1 and $t2";
$db->Select($query);
$i=0;
while($row=$db->Fetch($i))
	{
	system("/opt/kiosk/sbin/print-cash-collection-receipt ".$row['cash_collection_external_id']);
//	echo $row['cash_collection_external_id'];
	$i++;
	}
?>
