<?php
$str="04110430043B0430043D0441002000380033002E003900390020044004430431002E0020041E0431043C0435043D044F0439002004310430043B043B044B0020043D043000200441044304320435043D04380440044B002004320020043E044404380441043004450020041C0435043304300424043E043D000A000000000000000000000000000000000000";
function ucs2utf($str)
{
//echo "./utf/convert '$str' <br>";
$fd=popen("./utf/convert '$str'","r");
$str1=fread($fd,10000);
pclose($fd);
return $str1;
}

//die();
ini_set("display_errors",0);
include_once ("../classes/class.serial.php");
// Let's start the class 
$serial = new phpSerial; 
//$operators=array("25099"=>array("code"=>"BEELINE","name"=>"БиЛайн","init_string"=>'AT+CGDCONT=1,"IP","internet.beeline.ru"',"ussd_balance"=>"#102#"),
//		"25001"=>array("code"=>"MTS","name"=>"МТС","init_string"=>'AT+CGDCONT=1,"IP","internet.mts.ru"',"ussd_balance"=>"*100#")
//		);
include("../config.php");
$operator=file_get_contents("/etc/kiosk/operator");
// We can change the baud rate 
//$serial->confBaudRate(2400); 

// etc... 

system("/opt/kiosk/sbin/if-down ppp0");
system("/opt/kiosk/sbin/if-down ppp0");
system("/opt/kiosk/sbin/killpppd");
sleep(3);
//die();
$models=array("SIEMENS"=>"SIEMENS MODEM","WAVECOM"=>"FARGO MODEM","NOKIA"=>"TELTONIKA");
$found_on=-1;
$found_m=-1;
//for($i=0;$i<4;$i++)
$model=file_get_contents("/etc/kiosk/modem-model");
$operator=file_get_contents("/etc/kiosk/operator");
 $i=file_get_contents("/etc/kiosk/modem");
    {
    
if(!$serial->deviceSet("$i"))
	{	die("Не удалось открыть порт");;} 
$serial->SaveParams();
$serial->confStopBits(1);
$serial->confFlowControl("none");
$serial->confCharacterLength(8);
$serial->confParity("none");

// We can change the baud rate 
$serial->confBaudRate(115200);
// Then we need to open it 
$serial->deviceOpen(); 

// To write into 
//echo str_replace("\n","",trim($read));
$serial->sendMessage("AT+CUSD=1,".$operators[$operator]['ussd_balance']."\n"); 
// Or to read from 
//sleep(10);
//echo "READ:";
$read = $serial->readPort(); 
sleep(5);
$read .= $serial->readPort(); 
$r=preg_match_all("/[-]*([0-9]+)[.]([0-9]+)/",$read,$arr);
if($r==0)
	{
	preg_match_all("/\"([0-9A-F]{12,1000})\"/",strtoupper($read),$arrr);
	$read=ucs2utf($arrr[1][0]);
	$r=preg_match_all("/[-]*([0-9]+)[.]([0-9]+)/",$read,$arr);
	}
if($r==0)
	{
    	$serial->deviceClose(); 
	$serial->RestoreParams();

	die("a=1&balance=-1");
	}
echo "a=1&balance=".$arr[0][0];
system("/opt/kiosk/sbin/update-balance '".$arr[0][0]."'");
// If you want to change the configuration, the device must be closed 
$serial->deviceClose(); 
$serial->RestoreParams();
      }
  
?>
