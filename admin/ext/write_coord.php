<?php
system("/opt/kiosk/sbin/setup-sensor-".$_GET['type']." ".$_GET['x']." ".$_GET['y']);
?>