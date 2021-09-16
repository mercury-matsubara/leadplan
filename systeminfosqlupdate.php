<?php

//systeminfosqllevelup
require_once("f_DB.php");
$Loginsql = "select * from systeminfo;";
$con = dbconect();																									// db接続関数実行
$result = $con->query($Loginsql);
while($result_row = $result->fetch_array(MYSQLI_ASSOC))
{
	$startdate = $result_row['STARTDATE'];
}
echo"更新前";
echo"\n";
echo $startdate;
$newdate = date("Y/m/d", strtotime("$startdate +1 year" ));

echo"</br>";
$Updatesql = "UPDATE systeminfo SET STARTDATE='$newdate' WHERE ORNERID='1'";					// db接続関数実行
$Update = $con->query($Updatesql);

$result = $con->query($Loginsql);
while($result_row = $result->fetch_array(MYSQLI_ASSOC))
{
	$newstartdate = $result_row['STARTDATE'];
}
echo"更新後";
echo"\n";
echo $newstartdate;