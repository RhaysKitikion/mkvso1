<?php
ini_set("display_errors",0);
$fd=popen("ls /dev/input/event?","r");
$str=fread($fd,2048);
pclose($fd);

$ar=explode("\n",$str);
//print_r($ar);
$pids=0;
$parent=1;
$pid_dev=array();
$res_dev="";
$stop_time=time()+10;
foreach($ar as $dev)
    {
    if($dev!="")
        {
	if(!$pd=pcntl_fork())
	    {
	    $pid= posix_getpid();
	    $parent=0;
	//	echo $dev."\n";
    		$fd=fopen("$dev","r");
    		if($fd)
    		    {
		        $info = stream_get_meta_data($fd);
		        //stream_set_timeout($fd,10);
		        $data=fread($fd,2048);
		        fclose($fd);
		        exit(0);
		    }
		    else
		    {
		    while(1&&time()<$stop_time);
		    }
	        exit (1);
	    }
	    else
	    {
	    $pid_dev[$pd]=$dev;
	    $pids++;//pcntl_wait($status);
	    }
        }
    }
    if($parent)
	{
	//print_r($pid_dev);
	$fnd=0;
	if(!pcntl_fork())
	    {
	    while(time()<$stop_time);
	    foreach($pid_dev as $p=>$l)
		posix_kill($p,SIGINT);

	    }
	for($i=0;$i<$pids&&$res_dev=="";$i++)
	    {
	    $status=0;
	    $pid=pcntl_wait($status);    
	    if($status==0)
	    $res_dev=$pid_dev[$pid];
	    }
	foreach($pid_dev as $p=>$l)
	    posix_kill($p,SIGINT);
	}
	echo "a=1&dev=".$res_dev;
?>