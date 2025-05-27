<?php
ini_set("display_errors",0);
system("/opt/kiosk/sbin/if-down ppp0");
system("/opt/kiosk/sbin/if-down ppp0");
system("/opt/kiosk/sbin/killpppd");
sleep(3);
include_once ("../classes/class.serial.php");
// Let's start the class 
$serial = new phpSerial; 


// We can change the baud rate 
//$serial->confBaudRate(2400); 

// etc... 



//die();
$models=array("SIEMENS"=>"SIEMENS","WAVECOM"=>"FARGO","NOKIA"=>"TELTONIKA");
$found_on=-1;
$found_m=-1;
for($i=0;$i<8;$i++)
    {
    
if(!$serial->deviceSet("/dev/ttyS$i"))
	{continue;} 
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
$serial->sendMessage("AT+CGMI\n"); 

// Or to read from 
//sleep(10);
//echo "READ:";
$read = $serial->readPort(); 

foreach ($models as $m=>$k)
    {
    if(strpos($read,$m)!=false)
	{
	$found_m=$m;
	$found_on="S".$i;
	$serial->deviceClose(); 
	$serial->RestoreParams();	
	break;
	}
    }

// If you want to change the configuration, the device must be closed 
$serial->deviceClose(); 
$serial->RestoreParams();
    if($found_m!=-1) 
    	{
    	$serial->deviceClose(); 
	$serial->RestoreParams();
    	break;
    	}
    }
for($i=0;$i<10&&$found_m==-1;$i++)
    {
    
if(!$serial->deviceSet("/dev/ttyUSB$i"))
	{continue;} 
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
$serial->sendMessage("AT+CGMI\n"); 

// Or to read from 
//sleep(10);
//echo "READ:";
$read = $serial->readPort(); 

foreach ($models as $m=>$k)
    {
    if(strpos(strtoupper($read),strtoupper($m))!=false)
	{
	$found_m=$m;
	$found_on="USB".$i;
	$serial->deviceClose(); 
	$serial->RestoreParams();	
	break;
	}
    }

// If you want to change the configuration, the device must be closed 
$serial->deviceClose(); 
$serial->RestoreParams();
    if($found_m!=-1) 
    	{
    	$serial->deviceClose(); 
	$serial->RestoreParams();
    	break;
    	}
    }


  if($found_m==-1)
  	{
	$modem['model']="undefined";
	$modem['port']=-1;  	  	
  	}
  	else
  	{
	$modem['model']=$models[$found_m];
	$modem['port']=$found_on;
	}
echo "a=1&port=".$modem['port']."&model=".$modem['model'];

?>
