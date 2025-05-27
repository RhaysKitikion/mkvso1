<?php
ini_set("display_errors",0);
include_once("../classes/class.serial.php");
// Let's start the class 
$serial = new phpSerial; 


// We can change the baud rate 
//$serial->confBaudRate(2400); 

// etc... 



//die();
$found_on=-1;
$found_m=-1;
		$validator['serial_number']="undefined";
		$validator['part_number']="undefined";
for($i=0;$i<4;$i++)
    {  
	if(!$serial->deviceSet("/dev/ttyS$i"))
		{
		continue;
		;
		} 
	$serial->SaveParams();
	$serial->confStopBits(1);
	$serial->confFlowControl("none");
	$serial->confCharacterLength(8);
	$serial->confParity("none");
	// We can change the baud rate 
	$serial->confBaudRate(9600);
	// Then we need to open it 
	$serial->ValidatorSetOptions();
	$serial->deviceOpen(); 
	// To write into 
	$bytes="";
	$bytes.=chr(0x02);
	$bytes.=chr(0x03);
	$bytes.=chr(0x06);
	$bytes.=chr(0x30);
	$bytes.=chr(0x41);
	$bytes.=chr(0xB3);
	$serial->sendMessage($bytes); 
	$read = $serial->readPort(); 
	$strlen=strlen($read);
	if($strlen==6&&strtoupper(bin2hex($read))=="02030600C282")
		{
		//getting serial
		$bytes="";
		$bytes.=chr(0x02);
		$bytes.=chr(0x03);
		$bytes.=chr(0x06);
		$bytes.=chr(0x37);
		$bytes.=chr(0xFE);
		$bytes.=chr(0xC7);
		$serial->sendMessage($bytes); 
		$read = $serial->readPort(); 
		$strlen=strlen($read);
		$flag=1;
		$res="";
		if($strlen<10)
			{
			$found_m=$i;
			$serial->deviceClose(); 
			$serial->RestoreParams();
			break;
			}
		for($ii=3;$ii<$strlen;$ii++)
			{
			if((int)bin2hex($read[$ii])==3)
				{
				$flag=0;
				}

			if($flag)
				{
				//bin2hex($read[$i])." - ";
				$res.=$read[$ii];
				}
			}
		preg_match_all("/[a-zA-Z0-9-]+/",$res,$arr);
		$validator['serial_number']=$arr[0][1];
		$validator['part_number']=$arr[0][0];
		$found_m=$i;
		$serial->deviceClose(); 		
		$serial->RestoreParams();
		
		break;
		}	
		$serial->deviceClose(); 		
		$serial->RestoreParams();		
// If you want to change the configuration, the device must be closed 
    if($found_m!=-1) break;
    }
 $validator['port']=$found_m;  

echo "a=1&port=".$validator['port']."&part_no=".$validator['part_number']."&serial_no=".$validator['serial_number'];
?>
