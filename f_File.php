<?php

/****************************************************************************************
function csv_write($CSV)


引数1	$CSV				CSV
引数2	$csv_path			CSVファイルパス

戻り値	なし
****************************************************************************************/
function csv_write($CSV){
	
	
	//------------------------//
	//          定数          //
	//------------------------//
	$csv_path = "./List/List_".session_id().".csv";
	
	
	
	//--------------------------//
	//  CSVファイルの追記処理  //
	//--------------------------//
	
//	$CSV = mb_convert_encoding($CSV,'sjis-win','utf-8');																		// 取得string文字コード変換
	
	$fp = fopen($csv_path, 'ab');																								// CSVファイルを追記書き込みで開く
	// ファイルが開けたか //
	if ($fp)
	{
		// ファイルのロックができたか //
		if (flock($fp, LOCK_EX))																								// ロック
		{
			// ログの書き込みを失敗したか //
			if (fwrite($fp , $CSV."\r\n") === FALSE)																			// CSV追記書き込み
			{
				// 書き込み失敗時の処理
			}
			
			flock($fp, LOCK_UN);																								// ロックの解除
		}
		else
		{
			// ロック失敗時の処理
		}
	}
	fclose($fp);																												// ファイルを閉じる
	return($csv_path);
}	
	
/****************************************************************************************
function check_mail()


引数	なし

戻り値	なし
****************************************************************************************/
function check_mail(){
	
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$mial_ini = parse_ini_file('./ini/mail.ini', true);
	
	//------------------------//
	//          定数          //
	//------------------------//
	$check_path = $mial_ini['syaken']['file_path'];																				// 送信確認ファイル
	$year = date_create('NOW');
	$year = date_format($year, "Y");
	$month = date_create('NOW');
	$month = date_format($month, "m");
	
	
	//------------------------//
	//          変数          //
	//------------------------//
	$buffer = "";
	
	//--------------------------//
	//  CSVファイルの追記処理  //
	//--------------------------//
	
	if(!file_exists($check_path))
	{
		$fp = fopen($check_path, 'ab');																							// 送信確認ファイルを追記書き込みで開く
		fclose($fp);				
	}
	
	$fp = fopen($check_path, 'a+b');																							// 送信確認ファイルを追記書き込みで開く
	// ファイルが開けたか //
	if ($fp)
	{
		// ファイルのロックができたか //
		if (flock($fp, LOCK_EX))																								// ロック
		{
			$buffer = fgets($fp);
			if($buffer != $year.$month)
			{
				ftruncate( $fp,0);
				// ログの書き込みを失敗したか //
				if (fwrite($fp ,$year.$month) === FALSE)																		// check_mail追記書き込み
				{
					// 書き込み失敗時の処理
				}
				syaken_mail_select();
			}
			flock($fp, LOCK_UN);																								// ロックの解除
		}
		else
		{
			// ロック失敗時の処理
		}
	}
	fclose($fp);																												// ファイルを閉じる
}	

/****************************************************************************************
function limit_mail($message)


引数	なし

戻り値	なし
****************************************************************************************/
function limit_mail($message){
	
	
	//------------------------//
	//        初期設定        //
	//------------------------//
	$mial_ini = parse_ini_file('./ini/mail.ini', true);
	require_once("f_Form.php");																									// Form関数呼び出し準備
	
	//------------------------//
	//          定数          //
	//------------------------//
	$check_path = $mial_ini['limit']['file_path'];																				// 送信確認ファイル
	$date = date_create("NOW");
	$date = date_format($date, "Y-m-d");
	
	
	//------------------------//
	//          変数          //
	//------------------------//
	$buffer = "";
	
	//--------------------------//
	//  CSVファイルの追記処理  //
	//--------------------------//
	
	if(!file_exists($check_path))
	{
		$fp = fopen($check_path, 'ab');																							// 送信確認ファイルを追記書き込みで開く
		fclose($fp);				
	}
	
	$fp = fopen($check_path, 'a+b');																							// 送信確認ファイルを追記書き込みで開く
	// ファイルが開けたか //
	if ($fp)
	{
		// ファイルのロックができたか //
		if (flock($fp, LOCK_EX))																								// ロック
		{
			$buffer = fgets($fp);
			if($buffer == "")
			{
				ftruncate( $fp,0);
				// ログの書き込みを失敗したか //
				if (fwrite($fp ,$date) === FALSE)																		// check_mail追記書き込み
				{
					// 書き込み失敗時の処理
				}
				else
				{
					make_limit_mail($message);
				}
			}
			flock($fp, LOCK_UN);																								// ロックの解除
		}
		else
		{
			// ロック失敗時の処理
		}
	}
	fclose($fp);																												// ファイルを閉じる
}	
?>