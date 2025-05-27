<?php
$fd=popen("php /var/www/admin/ext/check_sensor.php","r");
echo fread($fd,1024);
pclose($fd);

?>