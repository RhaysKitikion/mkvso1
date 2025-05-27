<?php
$fd=popen("php /var/www/admin/ext/get_sensor_coord.php","r");
echo fread($fd,1024);
pclose($fd);

?>