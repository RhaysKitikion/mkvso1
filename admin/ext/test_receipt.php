<?php
$printer_name=file_get_contents("/etc/kiosk/printer-name");
//echo "/opt/kiosk/bin/write-receipt-test payment /var/opt/kiosk/cache/receipt-templates/payment-receipt.template; cat /tmp/receipt_00000000000000000000_00000000-0000-0000-0000-000000000000 | lpr -P printer";
system("/opt/kiosk/bin/write-receipt-test payment /var/opt/kiosk/cache/receipt-templates/payment-receipt.template; cat /tmp/receipt_00000000000000000000_00000000-0000-0000-0000-000000000000 | lpr -P printer");
echo "Отправлен на печать";

?>