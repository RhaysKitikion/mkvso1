<?php
ini_set("display_errors",0);
include_once ("../classes/class.serial.php");
// Let's start the class 
$serial = new phpSerial; 


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

$serial->sendMessage("AT+COPS=3,2\n"); 
$read = $serial->readPort(); 
//echo str_replace("\n","",trim($read));
$serial->sendMessage("AT+COPS?\n"); 

// Or to read from 
//sleep(10);
//echo "READ:";
$read = $serial->readPort(); 
$read=str_replace('"',"",$read);
$r=preg_match_all("/([0-9]+),([0-9]+),([0-9]+)/",$read,$arr);
if($r==0)
	{
    	$serial->deviceClose(); 
	$serial->RestoreParams();

	die("a=1&oper=-1");
	}
echo "a=1&oper=".$arr[3][0];

// If you want to change the configuration, the device must be closed 
$serial->deviceClose(); 
$serial->RestoreParams();
      }
  
?>
