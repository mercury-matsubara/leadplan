<?php

//systeminfosqlcheck
require_once("f_DB.php");
$Loginsql = "select * from systeminfo;";
$con = dbconect();																									// dbÚ‘±ŠÖ”ŽÀs
$result = $con->query($Loginsql);
while($result_row = $result->fetch_array(MYSQLI_ASSOC))
{
	$startdate = $result_row['STARTDATE'];
}

echo $startdate;
