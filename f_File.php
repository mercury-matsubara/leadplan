<?php

/****************************************************************************************
function csv_write($CSV)


����1	$CSV				CSV
����2	$csv_path			CSV�t�@�C���p�X

�߂�l	�Ȃ�
****************************************************************************************/
function csv_write($CSV){
	
	
	//------------------------//
	//          �萔          //
	//------------------------//
	$csv_path = "./List/List_".session_id().".csv";
	
	
	
	//--------------------------//
	//  CSV�t�@�C���̒ǋL����  //
	//--------------------------//
	
//	$CSV = mb_convert_encoding($CSV,'sjis-win','utf-8');																		// �擾string�����R�[�h�ϊ�
	
	$fp = fopen($csv_path, 'ab');																								// CSV�t�@�C����ǋL�������݂ŊJ��
	// �t�@�C�����J������ //
	if ($fp)
	{
		// �t�@�C���̃��b�N���ł����� //
		if (flock($fp, LOCK_EX))																								// ���b�N
		{
			// ���O�̏������݂����s������ //
			if (fwrite($fp , $CSV."\r\n") === FALSE)																			// CSV�ǋL��������
			{
				// �������ݎ��s���̏���
			}
			
			flock($fp, LOCK_UN);																								// ���b�N�̉���
		}
		else
		{
			// ���b�N���s���̏���
		}
	}
	fclose($fp);																												// �t�@�C�������
	return($csv_path);
}	
	
/****************************************************************************************
function check_mail()


����	�Ȃ�

�߂�l	�Ȃ�
****************************************************************************************/
function check_mail(){
	
	
	//------------------------//
	//        �����ݒ�        //
	//------------------------//
	$mial_ini = parse_ini_file('./ini/mail.ini', true);
	
	//------------------------//
	//          �萔          //
	//------------------------//
	$check_path = $mial_ini['syaken']['file_path'];																				// ���M�m�F�t�@�C��
	$year = date_create('NOW');
	$year = date_format($year, "Y");
	$month = date_create('NOW');
	$month = date_format($month, "m");
	
	
	//------------------------//
	//          �ϐ�          //
	//------------------------//
	$buffer = "";
	
	//--------------------------//
	//  CSV�t�@�C���̒ǋL����  //
	//--------------------------//
	
	if(!file_exists($check_path))
	{
		$fp = fopen($check_path, 'ab');																							// ���M�m�F�t�@�C����ǋL�������݂ŊJ��
		fclose($fp);				
	}
	
	$fp = fopen($check_path, 'a+b');																							// ���M�m�F�t�@�C����ǋL�������݂ŊJ��
	// �t�@�C�����J������ //
	if ($fp)
	{
		// �t�@�C���̃��b�N���ł����� //
		if (flock($fp, LOCK_EX))																								// ���b�N
		{
			$buffer = fgets($fp);
			if($buffer != $year.$month)
			{
				ftruncate( $fp,0);
				// ���O�̏������݂����s������ //
				if (fwrite($fp ,$year.$month) === FALSE)																		// check_mail�ǋL��������
				{
					// �������ݎ��s���̏���
				}
				syaken_mail_select();
			}
			flock($fp, LOCK_UN);																								// ���b�N�̉���
		}
		else
		{
			// ���b�N���s���̏���
		}
	}
	fclose($fp);																												// �t�@�C�������
}	

/****************************************************************************************
function limit_mail($message)


����	�Ȃ�

�߂�l	�Ȃ�
****************************************************************************************/
function limit_mail($message){
	
	
	//------------------------//
	//        �����ݒ�        //
	//------------------------//
	$mial_ini = parse_ini_file('./ini/mail.ini', true);
	require_once("f_Form.php");																									// Form�֐��Ăяo������
	
	//------------------------//
	//          �萔          //
	//------------------------//
	$check_path = $mial_ini['limit']['file_path'];																				// ���M�m�F�t�@�C��
	$date = date_create("NOW");
	$date = date_format($date, "Y-m-d");
	
	
	//------------------------//
	//          �ϐ�          //
	//------------------------//
	$buffer = "";
	
	//--------------------------//
	//  CSV�t�@�C���̒ǋL����  //
	//--------------------------//
	
	if(!file_exists($check_path))
	{
		$fp = fopen($check_path, 'ab');																							// ���M�m�F�t�@�C����ǋL�������݂ŊJ��
		fclose($fp);				
	}
	
	$fp = fopen($check_path, 'a+b');																							// ���M�m�F�t�@�C����ǋL�������݂ŊJ��
	// �t�@�C�����J������ //
	if ($fp)
	{
		// �t�@�C���̃��b�N���ł����� //
		if (flock($fp, LOCK_EX))																								// ���b�N
		{
			$buffer = fgets($fp);
			if($buffer == "")
			{
				ftruncate( $fp,0);
				// ���O�̏������݂����s������ //
				if (fwrite($fp ,$date) === FALSE)																		// check_mail�ǋL��������
				{
					// �������ݎ��s���̏���
				}
				else
				{
					make_limit_mail($message);
				}
			}
			flock($fp, LOCK_UN);																								// ���b�N�̉���
		}
		else
		{
			// ���b�N���s���̏���
		}
	}
	fclose($fp);																												// �t�@�C�������
}	
?>