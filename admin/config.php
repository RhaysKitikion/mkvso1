<?php
$db_path="/var/lib/kiosk/kiosk.db";
$roles=array("Инкассатор"=>"incas","Техник"=>"tech","Администратор"=>"adm");
if(isset($_GET['sub']))
	{
	foreach($roles as $k=>$p)
		{
		if($k==$_GET['sub'])
			$_GET['role']=$p;
		}
	$pass=file_get_contents("/etc/kiosk/pass-".$_GET['role']);
	if($_GET['pass']==$pass)
		{
		$_POST['role']=$_GET['role'];
		}
	}

$operators=array("25099"=>array("code"=>"BEELINE","name"=>"БиЛайн","init_string"=>'AT+CGDCONT=1,"IP","internet.beeline.ru"',"ussd_balance"=>"#102#"),
		"25001"=>array("code"=>"MTS","name"=>"МТС","init_string"=>'AT+CGDCONT=1,"IP","internet.mts.ru"',"ussd_balance"=>"*100#"),
		"25002"=>array("code"=>"MEGAFON","name"=>"Мегафон","init_string"=>'AT+CGDCONT=1,"IP","internet"',"ussd_balance"=>"*100#"),
		"25020"=>array("code"=>"TELE2","name"=>"Теле2","init_string"=>'AT+CGDCONT=1,"IP","internet.TELE2.ru"',"ussd_balance"=>"*105#")
		);
$register_errors=array("-1"=>"Неверный номер терминала","-2"=>"ХЗ","-3"=>"Неверный код регистрации.","-4"=>"Неверный запрос.","-5"=>"Не удалось отправить данные утилите регистрации","-6"=>"Не удалось выполнить команду регистрации. Обратитесь к разработчику.");
$soft=array("kiosk"=>"Ядро управления работой терминала","kiosk-user-gui"=>"Интерфейс пользователя","kiosk-sys"=>"Служебные утилиты","kiosk-admin-gui"=>"Интерфейс администратора");		                                                                                                                                                                                                                $COMMON_URL="http://localhost:9001/kiosk/local.php";

$COMMANDS = array(
	1 => '/opt/kiosk/sbin/execute-reboot-command',
	2 => '/opt/kiosk/sbin/execute-shutdown-command',
	3 => '/opt/kiosk/sbin/execute-block-command',
	4 => '/opt/kiosk/sbin/execute-unblock-command',
	5 => '/opt/kiosk/sbin/execute-update-payment-types-command',
	6 => '/opt/kiosk/sbin/execute-update-commission-rates-command',
	7 => '/opt/kiosk/sbin/execute-update-agent-requisites-command',
	8 => '/opt/kiosk/sbin/execute-verify-command',
	9 => '/opt/kiosk/sbin/execute-get-sim-data-command',
	10 => '/opt/kiosk/sbin/execute-start-vpn-command',
	11 => '/opt/kiosk/sbin/cancel-commands',
	1001 => '/opt/kiosk/sbin/run-common-configurator',
	1002 => '/opt/kiosk/sbin/execute-update-payment-types-command && /opt/kiosk/sbin/execute-update-agent-requisites-command'
);
$MAP = array(
	"Перезагрузить" => 1,
	"Выключить" => 2,
	"Приостановить работу" => 3,
	"Возобновить работу" => 4,
	"Обновить список услуг" => 5,
	"Обновить ставки комиссии" => 6,
	"Обновить информацию о владельце" => 7,
	"Отправить непроведенные платежи" => 8,
	"Получить данные о SIM-карте" => 9,
	"Запустить VPN" => 10,
	"Отменить невыполненные команды" => 11,
	"Запустить конфигуратор" => 1001,
	"Обновить всю информацию" => 1002
);
$ERRORS = array(
	 0 => 'OK',
	 1 => 'неизвестный номер терминала',
	 2 => 'терминал заблокирован',
	 3 => 'ошибка шифрования',
	 4 => 'повторите позднее',
	 5 => 'неверная подпись',
	 7 => 'неизвестная услуга',
	 9 => 'неизвестный владелец терминала',
	11 => 'пропущено поле',
	13 => 'неверный запрос',
	15 => 'ошибка базы данных',
	255 => 'команда не реализована',
);
function ReadFromFile($filename)
{
	return file_exists($filename) ? file_get_contents($filename) : '';
}

function GetSoftwareVersion()
{
$fd=popen("dpkg -l | grep kiosk","r");
$str=fread($fd,2048);
pclose($fd);
$arr=explode("\n",$str);
$res=array();
foreach($arr as $ar)
	{
	preg_match_all("/([^\s]+)([\s]+)([^\s]+)([\s]+)([^\s]+)([\s]+)([^\s]+)([\s]+)/",$ar,$arrr);
	$res[$arrr[3][0]]=$arrr[5][0];
	}

return $res;
}
function  GetStackIncas()
 {
	return ReadFromFile("/etc/kiosk/stack-incas");
}

function  GetPassAdm()
 {
	return ReadFromFile("/etc/kiosk/pass-adm");
}

function  GetPassTech()
 {
	return ReadFromFile("/etc/kiosk/pass-tech");
}

function  GetPassIncas()
 {
	return ReadFromFile("/etc/kiosk/pass-incas");
}

function  GetBalance()
 {
	return ReadFromFile("/var/opt/kiosk/cache/balance");
}


function  GetInitString()
 {
	return ReadFromFile("/etc/kiosk/init-string");
}
function  GetUssdBalance()
 {
	return ReadFromFile("/etc/kiosk/ussd-balance");
}

function  GetPS()
 {
	return ReadFromFile("/etc/kiosk/ps");
}
function  GetAltPS()
 {
	return ReadFromFile("/etc/kiosk/alt-ps");
}
function  GetMonitoring()
 {
	return ReadFromFile("/etc/kiosk/monitoring");
}
function  GetMonitoringTimer()
 {
	return ReadFromFile("/etc/kiosk/monitoring-timer");
}
function  GetConnection()
 {
	return ReadFromFile("/etc/kiosk/connection");
}
function  GetSmsWarning()
 {
	return ReadFromFile("/etc/kiosk/sms-warning");
}
function  GetSmsNumber()
 {
	return ReadFromFile("/etc/kiosk/sms-number");
}
function  GetVpnEnabled()
 {
	return ReadFromFile("/etc/kiosk/vpn-enabled");
}
function  GetVpnAddress()
 {
	return ReadFromFile("/etc/kiosk/vpn-address");
}

function GetAutoupdate()
 {
	return ReadFromFile("/etc/kiosk/autoupdate");
}

function GetOperator()
{
	return ReadFromFile("/etc/kiosk/operator");
}

function GetTerminalID()
{
	return ReadFromFile("/etc/kiosk/terminal");
}
function GetValidatorPath()
{
	return ReadFromFile("/etc/kiosk/validator");
}
function GetPrinterPath()
{
	return ReadFromFile("/etc/kiosk/printer");
}
function GetModemPath()
{
	return ReadFromFile("/etc/kiosk/modem");
}
function GetSensorPath()
{
	return ReadFromFile("/etc/kiosk/sensor");
}
function GetValidatorModel()
{
	return ReadFromFile("/etc/kiosk/validator-model");	
}
function GetPrinterModel()
{
	return ReadFromFile("/etc/kiosk/printer-model");	
}
function GetModemModel()
{
	return ReadFromFile("/etc/kiosk/modem-model");	
}
function GetSensorModel()
{
	return ReadFromFile("/etc/kiosk/sensor-model");	
}

function GetServiceNumber()
{
	return ReadFromFile("/etc/kiosk/service-number");
}

function RegisterTerminal($token, $countryName, $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress)
{
	$registrationData = array(
		"token" => $token,
		"countryName" => $countryName,
		"stateOrProvinceName" => $stateOrProvinceName,
		"localityName" => $localityName,
		"organizationName" => $organizationName,
		"organizationalUnitName" => $organizationalUnitName,
		"commonName" => $commonName,
		"emailAddress" => $emailAddress,
	);
	$fd = popen("/opt/kiosk/sbin/register-terminal", "w");
	if (!is_resource($fd)) {
		return -6;
	}
	foreach ($registrationData as $str) {
		if (false === fwrite($fd, $str . "\n")) {
			pclose($fd);
			return -5;
		}
	}
	$return_var = pclose($fd);
	switch ($return_var) {
		case 0:
			break;
		case 1: // wrong request
			return -4;
		case 2: // wrong token
			return -3;
		case 3: // unknown error
		default:
			return -2;
	}
	$terminalID = GetTerminalID();
	if (!$terminalID) {
		return -1;
	}
	return $terminalID;
}
function ActivationCode()
{
$fd=popen("/opt/kiosk/sbin/hdparm","r");
$str=fread($fd,1024*1024);
pclose($fd);
$nm=preg_match_all("/SerialNo=([^\n]*)/",$str,$arr);
if($nm==0)
    return "00000000";
$serials=array();
foreach($arr[1] as $k)
    {
    if(!in_array(trim($k),$serials))
	$serials[]=trim($k);
    }
$str="";
foreach($serials as $ser)
    {
    $str.=$ser." ";
    }
$str=md5($str);
$code="";
for($i=0;$i<strlen($str);$i++)
    {
    if($i%4==0)$code.=$str[$i];
    }

return $code;
}
?>
