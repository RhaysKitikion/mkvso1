<?php
system("/opt/kiosk/sbin/setup-rights");
$fd=popen("tail -n 18 /var/log/messages","r");
echo fread($fd,10000);
pclose($fd);
?>