<?php
$sensor=file_get_contents("/etc/kiosk/sensor");
$fd=fopen($sensor,"r");
$coord['x']=-1;
$coord['y']=-1;
$stop_time=time()+10;
if(!$pid=pcntl_fork())
{
while(($coord['x']==-1||$coord['y']==-1)&&time()<$stop_time)
    {
    $str=fread($fd,16);
    $data=unpack("Ltm1/Ltm2/stype/scode/Ldata",$str);
    if($data['type']==3&&$data['code']==0)
	{
	$coord['x']=$data['data'];
	}
    if($data['type']==3&&$data['code']==1)
	{
	$coord['y']=$data['data'];
	}
    }
echo "a=1&x=".$coord['x']."&y=".$coord['y'];
}
else
{
while(time()<$stop_time&&!pcntl_waitpid  ( $pid  , $status ,WNOHANG ));
posix_kill($pid,SIGINT);

}
fclose($fd);
?>