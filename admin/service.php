<?php
ini_set("display_errors", 0);
include ("classes/db.php");
include ("config.php");


?>
<?php

if (isset($_REQUEST['do_command']) && isset($MAP[$_REQUEST['do_command']])) {
	
	ob_start();
	system($COMMANDS[$MAP[$_REQUEST['do_command']]], $return_var);
	ob_clean();
//echo $return_var;
	$error = $return_var && isset($ERRORS[$return_var]) ? $ERRORS[$return_var] : "неизвестная ошибка";
	$message = $return_var ? "Команда не выполнилась. Ошибка: $error." : "Команда выполнилась успешно.";
	}
?>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type='text/css'>
body {
	background: url(bg.jpg) no-repeat;
	font-weight: bold;
	font-family: tahoma, sans-serif;
}
i
{
font-size:12px;
}
.touch {
	color: white;
	width: 75px;
	margin: 5px;
	height: 75px;
	list-style-type: none;
}

.touch3 {
	border: 1px solid black;
	font-family: tahoma, sans-serif;
	font-size: 25px;
	background-color: #999999;
	color: white;
	width: 225px;
	height: 75px;
}

.touch_free {
	border: 1px solid black;
	font-family: tahoma, sans-serif;
	font-size: 25px;
	background-color: #999999;
	color: white;
}

input.service_num {
	font-size: 25px;
	width: 220px;
}

.numpad {
	font-style: italic;
	font-weight: bold;
	color: blue;
}

fieldset {
	font-weight: bold;
	font-family: tahoma, sans-serif;
}

button {
	font-weight: bold;
	font-family: tahoma, sans-serif;
}

#keyboard {
	font-size: 110%;
	margin-bottom: .6em
}

div.kb {
	position: relative;
	width: 554px;
	height: 191px;
	background: url(kbd.jpg)
}

div.kb div,div.kb div td {
	font: 11px Tahoma, sans-serif;
	text-align: center
}

div.kb div td {
	padding: 0 2px;
	vertical-align: middle
}

div.kb div table {
	width: 100%;
	height: 35px;
	margin: -2px 0 0 0;
	padding: 0
}

div.kb div table,div.kb div td {
	border-collapse: collapse
}

div.kb div {
	position: absolute;
	height: 35px;
	cursor: pointer
}

div.kb font.b {
	position: absolute;
	top: 1px;
	left: 5px;
	color: #000
}

div.kb font.r {
	position: absolute;
	right: 5px;
	bottom: 3px;
	color: #f00
}

div.kb div center {
	padding-top: 10px
}
#datepicker1
	{
	position:absolute;
	
	}
#datepicker2
	{
	position:absolute;
	}
	.keyboard1
				{
				position:absolute;
				top:260px;
				left:80px;
				user-select:none;
				-moz-user-select:none;				
				}
.keyboard1 div {
 text-align: center;
 background: white;
 opacity:0.9;
-moz-border-radius: 5px; -webkit-border-radius: 5px; 
padding-top:8px; 
padding-left:10px;
padding-right:10px;
}

.keyboard1 button {
 height: 60px;
 min-width: 70px;
 color:white;
 font-size: 24px;
 font-weight:bold;
 background: #4d4948;
 border:0px;
 margin:2px;
 -moz-border-radius: 5px; -webkit-border-radius: 5px; 
}
#key_spacebar
	{
	width:438px;
	}
#key_0
	{
	width:145px;
	}

#spacer_key, #spacer_key2, #spacer_key3, #spacer_key4
{
background:transparent !important;
min-width:20px !important;
}

#keyboard1.shift #key_leftshift,
#keyboard1.shift #key_rightshift,
#keyboard1.altGr #key_altgr,
#keyboard1.capsLock #key_capslock {
  background-color: #fd9;
}			
.center_wrapper
	{
	text-align:center;
	width:100%;
	}	
.inp
	{
	font-size:24px;
	margin:10px;
	}
.links
	{
	font-size:20px;
	}
</style>

<link type="text/css" href="css/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<link href="js/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="/admin/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="/admin/js/tiny_mce/plugins/filemanager/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="/admin/js/tiny_mce/plugins/imagemanager/jscripts/mcimagemanager.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({

                mode : "textareas",
                theme : "advanced",              
                plugins : "table_in_style,safari,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,pagebreak",
                theme_advanced_buttons1_add_before : "save,newdocument,separator",
                theme_advanced_buttons3_add_before : "tablecontrols,separator",
                theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage,table_in_style",
                theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
                theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",           
            plugin_insertdate_dateFormat : "%d-%m-%Y",
                plugin_insertdate_timeFormat : "%H:%M:%S",
                //external_link_list_url : "example_data/example_link_list.js",
                //external_image_list_url : "example_data/example_image_list.js",
                //flash_external_list_url : "example_data/example_flash_list.js",
                //template_external_list_url : "example_data/example_template_list.js",
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true,
                apply_source_formatting : true,
                media_strict : false,
                width : "100%",
                height: "500",
                language : "ru",
                convert_urls : false,
                relative_urls : false,
                file_browser_callback : "filemanager"   
});

                
function filemanager(field_name, url, type, win)
{       
        if (type=='image') { mcImageManager.filebrowserCallBack(field_name, url, type, win); }
        else { mcFileManager.filebrowserCallBack(field_name, url, type, win); }
}
</script>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.osk.js"></script>
<script src="js/jqueryFileTree.js" type="text/javascript"></script>
<script type="text/javascript" src="js/func.js"></script>
<script type="text/javascript"> 
$(function(){
	<?php 
	if(isset($_POST['role'])&&in_array($_POST['role'],$roles))
	{
	?>
	// Tabs
	var options = {};
	$('#dialog').dialog({ autoOpen: false,modal: true,buttons:{"OK":function(){$(this).dialog('close');}} });

	<?php if (isset($_REQUEST['save_incas'])) { ?>

	$('#tabs').tabs({ selected: 3,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['activation'])) { ?>

	$('#tabs').tabs({ selected: 3,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['idle_time'])) { ?>

	$('#tabs').tabs({ selected: 0,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});
	
	<?php } else if (isset($_REQUEST['save_file'])) { ?>

	$('#tabs').tabs({ selected: 4,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'incass') { ?>

	$('#dialog').dialog("option","buttons",{"Ok":function (){$("#dialog").dialog("close");}}).html("Инкассация успешно проведена");
	$('#dialog').dialog('open');
	$('#tabs').tabs({ selected: 3,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['sensor'])) { ?>

	$('#dialog').dialog("option","buttons",{"Ok":function (){$("#dialog").dialog("close");}}).html("Настройки сохранены");
	$('#dialog').dialog('open');
	$('#tabs').tabs({ selected: 1,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['do_command'])) { 
	if($_REQUEST['do_command']=='Получить данные о SIM-карте' || $_REQUEST['do_command']=='Запустить VPN')
	{
	?>
	$('#tabs').tabs({ selected: 5,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});
	<?php
	}
	else
	if($_REQUEST['do_command']=='Обновить информацию о владельце' || $_REQUEST['do_command']=='Обновить ставки комиссии'|| $_REQUEST['do_command']=='Обновить список услуг')
	{
	?>
	$('#tabs').tabs({ selected: 4,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});
	<?php
	}
	else
	?>
	$('#tabs').tabs({ selected: 2,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});

	<?php } else if (isset($_REQUEST['serv_num'])||isset($_REQUEST['set_tech_pass'])||isset($_REQUEST['set_incas_pass'])||isset($_REQUEST['set_adm_pass'])) { ?>

	$('#dialog').html("Настройки сохранены");
	$('#dialog').dialog("option","buttons",{"Ok":function (){$("#dialog").dialog("close");}}).dialog('open');
	$('#tabs').tabs({ selected: 0,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});	

	<?php } else if (isset($_REQUEST['save_comm'])) { ?>

	$('#dialog').html("Настройки сохранены");
	$('#dialog').dialog("option","buttons",{"Ok":function (){$("#dialog").dialog("close");}}).dialog('open');
	$('#tabs').tabs({ selected: 5,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});	

	<?php } else if (isset($_REQUEST['save_software'])) { ?>

	$('#dialog').html("Настройки сохранены");
	$('#dialog').dialog("option","buttons",{"Ok":function (){$("#dialog").dialog("close");}}).dialog('open');
	$('#tabs').tabs({ selected: 6,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});	

	<?php } else { ?>

	$('#tabs').tabs({ selected: 0,show: function (event,ui){$("#keyboard").html("");$("#keyboard1").html("");}});			

	<?php } ?>

	$('#tabs').show("slow");
	<?php
	}
	else
	{
	?>

	<?php
	}
	?>
});
var key_show=0;
</script>

</head>

<body>


<div id="dialog" title="Сообщение" style='display: none; width: 100%;'></div>

<?php
if(isset($_POST['role'])&&in_array($_POST['role'],$roles))
{
?>
<div align=center style='color:red'>После окончания работы в сервисном меню - НЕ ЗАБУДЬТЕ ПЕРЕЗАГРУЗИТЬ ТЕРМИНАЛ!</div>
<div id="tabs" style='display: none'  >
	<ul>
	<?php 
	if($_POST['role']=="adm") echo'<li><a href="#tabs-0">Локальные настройки</a></li>';
	if($_POST['role']=="adm") echo'	<li><a href="#tabs-1">Устройства</a></li>';
	if($_POST['role']=="adm") echo'	<li><a href="#tabs-2">Команды</a></li>';
	if($_POST['role']=="adm") echo'	<li><a href="#tabs-3">Регистрация ПО</a></li>';
	if($_POST['role']=="adm") echo'	<li><a href="#tabs-4">Локальный сайт</a></li>';
	?>
	</ul>
	<?php if($_POST['role']=="adm"){?><div id="tabs-0"><?php include("tabs/local.php"); ?></div><?php }?>
	<?php if($_POST['role']=="adm"){?><div id="tabs-1"><?php include("tabs/devices.php"); ?></div><?php }?>
	<?php if($_POST['role']=="adm"){?><div id="tabs-2"><?php include("tabs/commands.php"); ?></div><?php }?>
	<?php if($_POST['role']=="adm"){?><div id="tabs-3"><?php include("tabs/register.php"); ?></div><?php }?>
	<?php if($_POST['role']=="adm"){?><div id="tabs-4"><?php include("tabs/software.php"); ?></div><?php }?>
</div>
<?php
}
else
{
?>

<div class=center_wrapper>
<table width=100% height=100%><tr><td valign=center align=center>
	<form method=GET autocomplete="off" id=login_form>
	<b>Вход в сервисное меню:</b><br>
	Секретная фраза: <input type=password name=pass id=pass  class=inp ><br>
		<?php
//		foreach($roles as $r=>$k)
		    $r="Администратор";
		    echo "<input type=hidden name=sub value='$r'>";
			echo "<input type=submit name=sub2 value='Войти' class='ui-state-default ui-corner-all inp'>";
		?>
		<br>	
	<!--<input type=submit value='Войти' class="ui-state-default ui-corner-all inp">-->
	</form>
	</td></tr></table>
</div>
<?php
}
?>
<div class='keyboard1'
	style='display: block; position: absolute; left: 100px'></div>
</body>
<div id=debug></div>
<div id=modal style='background:white;opacity:0.8;position:absolute;top:0px;left:0px;width:100%;height:100%;display:none;z-index:100;text-align:center;vertical-align:middle'></div>
</html>
