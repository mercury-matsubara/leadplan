<?php
session_start();
require_once("f_Construct.php");
require_once("f_DB.php");
$form_ini = parse_ini_file('./ini/form.ini', true);
startJump($_POST);
$filename = $_SESSION['filename'];
if($filename == 'zaikokei_5')
{
	$path = make_csv_zaikokei($_SESSION['zaikokei']);
}
else
{
	$path = make_csv($_SESSION['list']);
}
$date =date_create("NOW");
$date = date_format($date, "Ymd");
if($filename == 'zaikokei_5')
{
	$tablename = "�݌Ɍv";
	$tablename = mb_convert_encoding($tablename,'sjis-win','SJIS');
}
else
{
	$tablenum = $form_ini[$filename]['use_maintable_num'];
	$tablename = $form_ini[$tablenum]['table_title'];
	$tablename = mb_convert_encoding($tablename,'sjis-win','SJIS');
}
$file_name = "List_".$tablename."_".$date.".csv";
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename="'.$file_name.'"'); 
header('Content-Length: '.filesize($path));
readfile($path);
unlink($path);
?>