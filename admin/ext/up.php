<?php
$fd=popen("/opt/kiosk/sbin/if-up ppp0","r");
pclose($fd);

?>