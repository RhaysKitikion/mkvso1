<?php
system("/opt/kiosk/sbin/rm-network-configured");
system("/opt/kiosk/sbin/execute-reboot-command");
echo "ok";
?>
