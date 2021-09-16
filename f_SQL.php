<?php

/************************************************************************************************************
function InsertSQL($post,$tablenum,$over)

引数	$post

戻り値	なし
************************************************************************************************************/
function InsertSQL($post,$tablenum,$over){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$columns = $form_ini[$tablenum]['insert_form_num'];
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];
	$mastertablenum = $form_ini[$tablenum]['seen_table_num'];
	$mastertablenum_array = explode(',',$mastertablenum);

	//------------------------//
	//          変数          //
	//------------------------//
	$columnName = "";
	$columnValue = "";
	$formatType = "";
	$insert_SQL = "";
	$singleQute = "";
	$key_array = array();
	$fieldtype = "";
	$serch_str = "";
	$key_id = array();
	$formtype ="";
	$delimiter = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	$insert_SQL .= "INSERT INTO ".$tableName." (";
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		$columnName = $form_ini[$columns_array[$i]]['column'];
		$insert_SQL .= $columnName.",";
	}
	if($mastertablenum != '')
	{
		for( $i = 0 ; $i < count($mastertablenum_array) ; $i++)
		{
			$insert_SQL .= $mastertablenum_array[$i]."CODE,";
		}
	}
	$insert_SQL = substr($insert_SQL,0,-1);
	$insert_SQL .= ")VALUES(";
	
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		$formtype = $form_ini[$columns_array[$i]]['form_type'];
		if($formtype == 1 || $formtype == 2|| $formtype == 4  )
		{
			$delimiter = "-";
		}
		else
		{
			$delimiter = "";
		}
		for($j = 0; $j < 5 ; $j++)
		{
			if($over == "")
			{
				$serch_str = "form_".$columns_array[$i]."_".$j;
			}
			else
			{
				$serch_str = "form_".$columns_array[$i]."_".$j."_".$over ;
			}
			if(isset($post[$serch_str]))
			{
				$columnValue .= $post[$serch_str].$delimiter;
			}
		}
		$columnValue = rtrim($columnValue,$delimiter);
		$fieldtype = $form_ini[$columns_array[$i]]['fieldtype'];
		$singleQute = $fieldtype_ini[$fieldtype];
		$insert_SQL .= $singleQute.$columnValue.$singleQute.",";
		$columnValue ="";
	}
	if($mastertablenum != '')
	{
		for($i = 0 ; $i < count($mastertablenum_array) ; $i++)
		{
			$insert_SQL .= $post[$mastertablenum_array[$i]."CODE"].",";
		}
	}
	$insert_SQL = substr($insert_SQL,0,-1);
	$insert_SQL .= ");";
	return($insert_SQL);
}


/************************************************************************************************************
function SelectSQL($post,$tablenum,$over)

引数	$post

戻り値	なし
************************************************************************************************************/
function SelectSQL($post,$tablenum,$over){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$columns = $form_ini[$tablenum]['insert_form_num'];
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];

	//------------------------//
	//          変数          //
	//------------------------//
	$columnName = "";
	$columnValue = "";
	$formatType = "";
	$select_SQL = "";
	$singleQute = "";
	$key_array = array();
	$fieldtype = "";
	$serch_str = "";
	$key_id = array();
	
	//------------------------//
	//          処理          //
	//------------------------//
	$select_SQL .= "SELECT * FROM ".$tableName." WHERE";
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		for($j = 0; $j < 5 ; $j++)
		{
			if($over == "")
			{
				$serch_str = "form_".$columns_array[$i]."_".$j;
			}
			else
			{
				$serch_str = "form_".$columns_array[$i]."_".$j."_".$over ;
			}
			if(isset($post[$serch_str]))
			{
				$columnValue .= $post[$serch_str];
				$columnValue = str_replace(" ", "", $columnValue); 
				$columnValue = str_replace("　", "", $columnValue);
			}
		}
		$columnName = $form_ini[$columns_array[$i]]['column'];
		$fieldtype = $form_ini[$columns_array[$i]]['fieldtype'];
		$singleQute = $fieldtype_ini[$fieldtype];
		$columnValue = rtrim($columnValue,"-");
		if ($columnValue != "")
		{
			$select_SQL .= " convert(replace(replace(".$columnName
						.",' ',''),'　','') using utf8) COLLATE utf8_unicode_ci = ";
			$select_SQL .= $singleQute.$columnValue.$singleQute." AND";
		}
		$columnValue ="";
	}
	$select_SQL = rtrim($select_SQL,'WHERE');
	$select_SQL = rtrim($select_SQL,'AND');
	$select_SQL .= ";";
//	echo ($select_SQL);
}


/************************************************************************************************************
function joinSelectSQL($post,$tablenum)

引数	$post

戻り値	なし
************************************************************************************************************/
function joinSelectSQL($post,$tablenum){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$columns = $form_ini[$tablenum]['insert_form_num'];
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];
	$masterNums = $form_ini[$tablenum]['seen_table_num'];
	$masterNums_array = explode(',',$masterNums);

	//------------------------//
	//          変数          //
	//------------------------//
	$columnName = "";
	$columnValue = "";
	$formatType = "";
	$select_SQL = "";
	$count_SQL = "";
	$singleQute = "";
	$key_array = array();
	$fieldtype = "";
	$formtype = "";
	$serch_str = "";
	$key_id = array();
	$masterName = array();
	$mastercolumns ="";
	$mastercolumns_array = array();
	$formatdate = "";
	$singleQute_start = "";
	$singleQute_end = "";
	$convert = "";
	$sql = array();
	
	//------------------------//
	//          処理          //
	//------------------------//
	$select_SQL .= "SELECT * FROM ".$tableName." ";
	$count_SQL .= "SELECT COUNT(*) FROM ".$tableName." ";
	if($masterNums != '')
	{
		for($i = 0 ; $i < count($masterNums_array) ; $i++)
		{
			$masterName[$i] = $form_ini[$masterNums_array[$i]]['table_name'];
			$select_SQL .= "LEFT JOIN ".$masterName[$i]." ON (".$tableName.".".
							$masterNums_array[$i]."CODE = ".$masterName[$i].".".
							$masterNums_array[$i]."CODE ) ";
			$count_SQL .= "LEFT JOIN ".$masterName[$i]." ON (".$tableName.".".
							$masterNums_array[$i]."CODE = ".$masterName[$i].".".
							$masterNums_array[$i]."CODE ) ";
		}
	}
	$select_SQL .= " WHERE";
	$count_SQL .= " WHERE";
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		$formtype = $form_ini[$columns_array[$i]]['form_type'];
		for($j = 0; $j < 5 ; $j++)
		{
			$serch_str = "form_".$columns_array[$i]."_".$j;
			if(isset($post[$serch_str]))
			{
				$columnValue .= $post[$serch_str];
				if($post[$serch_str] != "" && $formtype != 9)
				{
					switch ($j)
					{
					case 0:
						$formatdate .='%Y';
						break;
					case 1:
						$formatdate .='%c';
						break;
					case 2:
						$formatdate .='%e';
						break;
					default:
						$formatdate .='';
					}
				}
			}
		}
		$columnName = $form_ini[$columns_array[$i]]['column'];
		$fieldtype = $form_ini[$columns_array[$i]]['fieldtype'];
		$singleQute = $fieldtype_ini[$fieldtype];
		if ($singleQute == '')
		{
			$convert = " ".$tableName.".".$columnName;
			$singleQute_start = " = ";
			$singleQute_end = "";
		}
		else
		{
			$convert =  " convert(replace(replace(".$tableName.".".$columnName
						.",' ',''),'　','') using utf8) COLLATE utf8_unicode_ci ";
			$singleQute_start = "LIKE '%";
			$singleQute_end = "%'";
		}
		if ($columnValue != "" && ($formtype >= 9 || $formtype == 3 || $formtype == 5 ))
		{
			$columnValue = str_replace(" ", "%", $columnValue); 
			$columnValue = str_replace("　", "%", $columnValue);
			$select_SQL .= $convert;
			$select_SQL .= $singleQute_start.$columnValue.$singleQute_end." AND";
			$count_SQL .= $convert;
			$count_SQL .= $singleQute_start.$columnValue.$singleQute_end." AND";
		}
		else if ($columnValue != "")
		{
			$select_SQL .= " DATE_FORMAT(".$tableName.".".$columnName.",'".$formatdate."') =";
			$select_SQL .= $singleQute.$columnValue.$singleQute." AND";
			$count_SQL .= " DATE_FORMAT(".$tableName.".".$columnName.",'".$formatdate."') =";
			$count_SQL .= $singleQute.$columnValue.$singleQute." AND";
			$formatdate = "";
		}
		$columnValue ="";
	}
	if($masterNums != '')
	{
		for($i = 0 ; $i < count($masterNums_array) ; $i++)
		{
			$mastercolumns = $form_ini[$masterNums_array[$i]]['insert_form_num'];
			$mastercolumns_array = explode(',',$mastercolumns);
			for($j = 0 ; $j < count($mastercolumns_array) ; $j++)
			{
				for($k = 0; $k < 5 ; $k++)
				{
					$serch_str = "form_".$mastercolumns_array[$j]."_".$k;
					if(isset($post[$serch_str]))
					{
						$columnValue .= $post[$serch_str];
						if($post[$serch_str] != "" && $formtype != 9)
						{
							switch ($k){
							case 0:
								$formatdate .='%Y';
								break;
							case 1:
								$formatdate .='%c';
								break;
							case 2:
								$formatdate .='%e';
								break;
							default:
								$formatdate .='';
							}
						}
					}
				}
				$columnName = $form_ini[$mastercolumns_array[$j]]['column'];
				$fieldtype = $form_ini[$mastercolumns_array[$j]]['fieldtype'];
				$formtype = $form_ini[$mastercolumns_array[$j]]['form_type'];
				$singleQute = $fieldtype_ini[$fieldtype];
				if ($singleQute == '')
				{
					$convert = " ".$masterName[$i].".".$columnName;
					$singleQute_start = " = ";
					$singleQute_end = "";
				}
				else
				{
					$convert =  " convert(replace(replace(".$masterName[$i].".".$columnName
								.",' ',''),'　','') using utf8) COLLATE utf8_unicode_ci ";
					$singleQute_start = "LIKE '%";
					$singleQute_end = "%'";
				}
				if ($columnValue != "" && ($formtype >= 9 || $formtype == 3 || $formtype == 5 ))
				{
					$columnValue = str_replace(" ", "%", $columnValue); 
					$columnValue = str_replace("　", "%", $columnValue);
					$select_SQL .= $convert;
					$select_SQL .= $singleQute_start.$columnValue.$singleQute_end." AND";
					$count_SQL .= $convert;
					$count_SQL .= $singleQute_start.$columnValue.$singleQute_end." AND";
				}
				else if($columnValue != "")
				{
					$select_SQL .= " DATE_FORMAT(".$masterName[$i].".".$columnName.",'".$formatdate."') =";
					$select_SQL .= $singleQute.$columnValue.$singleQute." AND";
					$count_SQL .= " DATE_FORMAT(".$masterName[$i].".".$columnName.",'".$formatdate."') =";
					$count_SQL .= $singleQute.$columnValue.$singleQute." AND";
					$formatdate = "";
				}
				$columnValue ="";
			}
		}
	}
	$select_SQL = rtrim($select_SQL,'WHERE');
	$select_SQL = rtrim($select_SQL,'AND');
	$count_SQL = rtrim($count_SQL,'WHERE');
	$count_SQL = rtrim($count_SQL,'AND');
	if(isset($post['sort']))
	{
		$orderby_column_num = $post['sort'];
		if($orderby_column_num != 0 && $orderby_column_num != 1)
		{
			$orderby_table_num = $form_ini[$orderby_column_num]['table_num'];
			$orderby_column_name = $form_ini[$orderby_column_num]['column'];
			$orderby_table_name = $form_ini[$orderby_table_num]['table_name'];
			$select_SQL .= " ORDER BY ".$orderby_table_name.".".
							$orderby_column_name." ".$post['radiobutton'];
			$count_SQL .= " ORDER BY ".$orderby_table_name.".".
							$orderby_column_name." ".$post['radiobutton'];
		}
	}
	$select_SQL .= ";";
	$count_SQL .= ";";
	$sql[0] = $select_SQL;
	$sql[1] = $count_SQL;
	return ($sql);
}





/************************************************************************************************************
function idSelectSQL($code_value,$tablenum,$code)

引数	$post

戻り値	なし
************************************************************************************************************/
function idSelectSQL($code_value,$tablenum,$code){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	
	//------------------------//
	//          定数          //
	//------------------------//
	$tableName = $form_ini[$tablenum]['table_name'];

	//------------------------//
	//          変数          //
	//------------------------//
	$select_SQL = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	$select_SQL .= "SELECT * FROM ".$tableName." WHERE";
	$select_SQL .= " ".$code." = ";
	$select_SQL .= $code_value." ";
	$select_SQL .= ";";
	return $select_SQL;
}


/************************************************************************************************************
function UpdateSQL($post,$tablenum,$over)

引数	$post

戻り値	なし
************************************************************************************************************/
function UpdateSQL($post,$tablenum,$over){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$columns = $form_ini[$tablenum]['insert_form_num'];
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];
	$mastertablenum = $form_ini[$tablenum]['seen_table_num'];
	$mastertablenum_array = explode(',',$mastertablenum);

	//------------------------//
	//          変数          //
	//------------------------//
	$columnName = "";
	$columnValue = "";
	$formatType = "";
	$update_SQL = "";
	$singleQute = "";
	$key_array = array();
	$fieldtype = "";
	$serch_str = "";
	$key_id = array();
	$formtype = "";
	$delimiter = "";
	//------------------------//
	//          処理          //
	//------------------------//
	$update_SQL .= "UPDATE ".$tableName." SET";
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		$formtype = $form_ini[$columns_array[$i]]['form_type'];
		if($formtype == 1 || $formtype == 2|| $formtype == 4  )
		{
			$delimiter = "-";
		}
		else
		{
			$delimiter = "";
		}
		for($j = 0; $j < 5 ; $j++)
		{
			if($over == "")
			{
				$serch_str = "form_".$columns_array[$i]."_".$j;
			}
			else
			{
				$serch_str = "form_".$columns_array[$i]."_".$j."_".$over ;
			}
			if(isset($post[$serch_str]))
			{
				$columnValue .= $post[$serch_str].$delimiter;
			}
		}
		$columnValue = rtrim($columnValue,$delimiter);
		$columnName = $form_ini[$columns_array[$i]]['column'];
		$fieldtype = $form_ini[$columns_array[$i]]['fieldtype'];
		$singleQute = $fieldtype_ini[$fieldtype];
		$update_SQL .= " ".$columnName." = ";
		$update_SQL .= $singleQute.$columnValue.$singleQute." ,";
		$columnValue ="";
	}
	if($mastertablenum != '')
	{
		for( $i = 0 ; $i < count($mastertablenum_array) ; $i++)
		{
			$update_SQL .= " ".$mastertablenum_array[$i]."CODE = ";
			$update_SQL .= $post[$mastertablenum_array[$i]."CODE"].",";
		}
	}
	$update_SQL = rtrim($update_SQL,',');
	$update_SQL .= " WHERE ".$tablenum."CODE = ".$post[$tablenum."CODE"];
	$update_SQL .= ";";
	return $update_SQL;
}


/************************************************************************************************************
function DeleteSQL($codeValue,$tablenum,$code)

引数	$post

戻り値	なし
************************************************************************************************************/
function DeleteSQL($codeValue,$tablenum,$code){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	
	//------------------------//
	//          定数          //
	//------------------------//
	$tableName = $form_ini[$tablenum]['table_name'];

	//------------------------//
	//          変数          //
	//------------------------//
	$delete_SQL = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	$delete_SQL .= "DELETE FROM ".$tableName." ";
	$delete_SQL .= " WHERE ".$code." = ".$codeValue;
	$delete_SQL .= ";";
	return($delete_SQL);
}



/************************************************************************************************************
function uniqeSelectSQL($post,$tablenum,$columns)

引数	$post

戻り値	なし
************************************************************************************************************/
function uniqeSelectSQL($post,$tablenum,$columns){
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];

	//------------------------//
	//          変数          //
	//------------------------//
	$columnName = "";
	$columnValue = "";
	$formatType = "";
	$select_SQL = "";
	$singleQute = "";
	$key_array = array();
	$fieldtype = "";
	$serch_str = "";
	$key_id = array();
	$uniqefiled = array();
	$isValueExit = true;
	$judge = true;
	$delimiter = "";
	$formtype = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	if(isset($post['uniqe']) == false)
	{
		$judge = false;
	}
	$select_SQL .= "SELECT * FROM ".$tableName." WHERE";
	for($i = 0 ; $i < count($columns_array) ; $i++)
	{
		if($columns_array[$i] == "")
		{
			break;
		}
		$uniqefiled = $columns_array[$i];
		$uniqefiled = explode('~',$columns_array[$i]);
		for($j = 0 ; $j < count($uniqefiled) ; $j++)
		{
			$formtype = $form_ini[$uniqefiled[$j]]['form_type'];
			if($formtype == 1 || $formtype == 2|| $formtype == 4  )
			{
				$delimiter = "-";
			}
			else
			{
				$delimiter = "";
			}
			for($k = 0; $k < 5 ; $k++)
			{
				$serch_str = "form_".$uniqefiled[$j]."_".$k;
				if(isset($post[$serch_str]))
				{
					$columnValue .= $post[$serch_str].$delimiter;
				}
			}
			$columnValue  = rtrim($columnValue,$delimiter);
			if(isset($post['uniqe'][$columns_array[$i]]))
			{
				if($post['uniqe'][$columns_array[$i]] != $columnValue )
				{
					$judge = false;
				}
			}
			$columnName = $form_ini[$uniqefiled[$j]]['column'];
			$fieldtype = $form_ini[$uniqefiled[$j]]['fieldtype'];
			$singleQute = $fieldtype_ini[$fieldtype];
			if (count($uniqefiled) == 1)
			{
				$select_SQL .= " ".$columnName." = ";
				$select_SQL .= $singleQute.$columnValue.$singleQute." OR";
			}
			else if( count($uniqefiled) > 1)
			{
				if($j == 0)
				{
					$select_SQL .="(";
				}
				$select_SQL .= " ".$columnName." = ";
				$select_SQL .= $singleQute.$columnValue.$singleQute." AND";
			}
			$columnValue ="";
		}
		if(count($uniqefiled) > 1)
		{
			$select_SQL = rtrim($select_SQL,'(');
			$select_SQL = rtrim($select_SQL,'AND');
			$select_SQL .= ") OR";
		}
	}
	$select_SQL = rtrim($select_SQL,'OR');
	$select_SQL = rtrim($select_SQL,'WHERE');
	$select_SQL .= ";";
	if($judge == true)
	{
		$select_SQL = "";
	}
	return $select_SQL;
}

/************************************************************************************************************
function kensakuSelectSQL($post,$tablenum)

引数	$post

戻り値	なし
************************************************************************************************************/
function kensakuSelectSQL($post,$tablenum){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$filename = $_SESSION['filename'];
	$columns = $form_ini[$filename]['sech_form_num'];
	$columns_array = explode(',',$columns);
	$tableName = $form_ini[$tablenum]['table_name'];
	$masterNums = $form_ini[$tablenum]['seen_table_num'];
	$masterNums_array = explode(',',$masterNums);
	$year = date_create('NOW');
	$year = date_format($year, "Y");
	$befor_year = ($year - 2);
	$after_year = ($year + 3);

	//------------------------//
	//          変数          //
	//------------------------//
	$select_SQL = "";
	$masterName = array();
	
	//------------------------//
	//          処理          //
	//------------------------//
	$select_SQL .= "SELECT * FROM ".$tableName." ";
	for($i = 0 ; $i < count($masterNums_array) ; $i++)
	{
		$masterName[$i] = $form_ini[$masterNums_array[$i]]['table_name'];
		$select_SQL .= "LEFT JOIN ".$masterName[$i]." ON (".$tableName.".".
						$masterNums_array[$i]."CODE = ".$masterName[$i].".".
						$masterNums_array[$i]."CODE ) ";
	}
	$select_SQL .="WHERE date_format(".$tableName."."
					.$form_ini[$columns_array[0]]['column'].",'%Y') BETWEEN ";
	$select_SQL .= $befor_year." AND ".$after_year." ;";
	return($select_SQL);
}

/************************************************************************************************************
function codeSelectSQL($code,$tablenum)

引数	$post

戻り値	なし
************************************************************************************************************/
function codeSelectSQL($code,$tablenum){
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$fieldtype_ini = parse_ini_file('./ini/fieldtype.ini');
	require_once 'f_DB.php';
	
	//------------------------//
	//          定数          //
	//------------------------//
	$filename = $_SESSION['filename'];
	$code_array = explode(',',$code);
	$tableName = $form_ini[$tablenum]['table_name'];
	$masterNums = $form_ini[$tablenum]['seen_table_num'];
	$masterNums_array = explode(',',$masterNums);

	//------------------------//
	//          変数          //
	//------------------------//
	$select_SQL = "";
	$masterName = array();
	
	//------------------------//
	//          処理          //
	//------------------------//
	$select_SQL .= "SELECT * FROM ".$tableName." ";
	for($i = 0 ; $i < count($masterNums_array) ; $i++)
	{
		$masterName[$i] = $form_ini[$masterNums_array[$i]]['table_name'];
		$select_SQL .= "LEFT JOIN ".$masterName[$i]." ON (".$tableName.".".
						$masterNums_array[$i]."CODE = ".$masterName[$i].".".
						$masterNums_array[$i]."CODE ) ";
	}
	$select_SQL .="WHERE";
	for($i = 0 ; $i < count($code_array) ; $i++ )
	{
		$select_SQL .= " ".$tablenum."CODE = ".$code_array[$i]." OR";
	}
	$select_SQL = rtrim($select_SQL,'OR');
	$select_SQL .= ";";
	return($select_SQL);
}


/************************************************************************************************************
function codeCountSQL($tablenum,$listtablenum)

引数	$post

戻り値	なし
************************************************************************************************************/
function codeCountSQL($tablenum,$listtablenum){
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	
	
	//------------------------//
	//          定数          //
	//------------------------//
	$tableName = $form_ini[$listtablenum]['table_name'];
	$code = $_SESSION['list']['id'];
	
	
	//------------------------//
	//          変数          //
	//------------------------//
	$sql = "";
	
	
	//------------------------//
	//          処理          //
	//------------------------//
	$sql = "SELECT COUNT(*) FROM ".$tableName." WHERE ".$tablenum."CODE = ".$code." ;";
	
	return($sql);
	
}
/************************************************************************************************************
function hannyuusyutuSQL($post)

引数	$post

戻り値	なし
************************************************************************************************************/
function hannyuusyutuSQL($post){
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$SQL_ini = parse_ini_file('./ini/SQL.ini', true);
	
	
	//------------------------//
	//          定数          //
	//------------------------//
	$filename = $_SESSION['filename'];
	
	
	//------------------------//
	//          変数          //
	//------------------------//
	$sqlresult = array();
	$sql = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	$sql = $SQL_ini[$filename]['sql1'];
	if(isset($post['4CODE']))
	{
		if($post['4CODE'] != '')
		{
			$sql .= $SQL_ini[$filename]['where'].' '.$post['4CODE']." AND genbainfo.GENBASTATUS = '0' ";
//			$sql .= $SQL_ini[$filename]['where'].' '.$post['4CODE'];
		}
		else
		{
			$sql .=  " WHERE genbainfo.GENBASTATUS = '0' ";
		}
	}
	else
	{
		$sql .=  " WHERE genbainfo.GENBASTATUS = '0' ";
	}
	$sql .= $SQL_ini[$filename]['sql2'];
	if(isset($post['4CODE']))
	{
		if($post['4CODE'] != '')
		{
			$sql .= $SQL_ini[$filename]['where'].' '.$post['4CODE']." AND genbainfo.GENBASTATUS = '0' ";
		}
		else
		{
			$sql .=  " WHERE genbainfo.GENBASTATUS = '0' ";
		}
	}
	else
	{
		$sql .=  " WHERE genbainfo.GENBASTATUS = '0' ";
	}
	$sql .= $SQL_ini[$filename]['sql3'];
	
	$sqlresult[0] = $SQL_ini[$filename]['sql'].$sql;
	$sqlresult[1] = "SELECT COUNT(*)".$sql;
	
	
	return($sqlresult);
	
}



/************************************************************************************************************
function getSQL_zaiko($post)

引数	$post

戻り値	なし
************************************************************************************************************/
function getSQL_zaiko($post){
	//------------------------//
	//        初期設定        //
	//------------------------//
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$SQL_ini = parse_ini_file('./ini/SQL.ini', true);
	
	
	//------------------------//
	//          定数          //
	//------------------------//
	$filename = $_SESSION['filename'];
	
	
	//------------------------//
	//          変数          //
	//------------------------//
	$sqlresult = array();
	$sql = "";
	$serchkey = "";
	
	//------------------------//
	//          処理          //
	//------------------------//
	$sql = $SQL_ini[$filename]['sql1'];
	if(isset($post['form_208_0']))
	{
		$format = "";
		$value = "";
		$isone = false;
		if($post['form_208_0'] != '')
		{
			$format .= '%Y';
			$value .= $post['form_208_0'];
			$isone = true;
		}
		if($post['form_208_1'] != '')
		{
			$format .= '%c';
			$value .= $post['form_208_1'];
			$isone = true;
		}
		if($post['form_208_2'] != '')
		{
			$format .= '%e';
			$value .= $post['form_208_2'];
			$isone = true;
		}
		if($isone)
		{
			$sql .= " WHERE  DATE_FORMAT( BUYDATE,'".$format."') = '".$value."' ";
		}
		if($post['form_209_0'] != '')
		{
			if($isone)
			{
				$sql .= " AND ";
			}
			else
			{
				$sql .= " WHERE ";
				$isone = true;
			}
			$sql .= " MAKEDATE = '".$post['form_209_0']."' ";
		}
		if($post['form_402_0'] != '')
		{
			if($isone)
			{
				$sql .= " AND ";
			}
			else
			{
				$sql .= " WHERE ";
				$isone = true;
			}
			$sql .= "  convert(replace(replace(carinfo.CARNAME,' ',''),'　','') using utf8) COLLATE utf8_unicode_ci LIKE '%".$post['form_402_0']."%' ";
		}
	}
	if(isset($post['sort']))
	{
		if($post['sort'] == '202')
		{
			$sql .= "ORDER BY zaikoinfo.BUYPRICE ".$post['radiobutton'].' ;';
		}
		else
		{
			$sql .= ' ;';
		}
	}
	else
	{
		$sql .= ' ;';
	}
	
	$sqlresult[0] = $SQL_ini[$filename]['sql'].$sql;
	$sqlresult[1] = "SELECT COUNT(*)".$sql;
	
	
	return($sqlresult);
	
}
?>
