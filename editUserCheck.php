<?php
	session_start();
	header('Expires:-1'); 
	header('Cache-Control:'); 
	header('Pragma:'); 
        header('Content-type: text/html; charset=Shift_JIS'); 
	require_once("f_Construct.php");
	start();
	require_once("f_DB.php");
	$isexist = true;
	$pass = $_SESSION['result_array']['LUSERPASS'];
	$checkResultarray = selectID($_SESSION['listUser']['id']);
	if(count($checkResultarray) == 0)
	{
		$isexist = false;
	}
?>
<!DOCTYPE html>
<style type="text/css">
	a.title {
		font-size: xx-large;
	}
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>�Ǘ��ҍX�V�ē���</title>
<link rel="stylesheet" type="text/css" href="./list_css.css">
<script src='./jquery-1.8.3.min.js'></script>
<script src='./jquery.corner.js'></script>
<script src='./inputcheck.js'></script>
<script src='./jquery.flatshadow.js'></script>
<script src='./button_size.js'></script>
<script language="JavaScript"><!--
	history.forward();
	var button = '';
	$(window).resize(function()
	{
		var t1 =  $('td.one').width();
		var t2 =  $('td.two').width();
		var w = $(window).width();
		var width_div = 0;
		if (w > 600)
		{
			width_div = w/2 - (t1 + t2)/2;
		}
		$('td.space').css({
			width : width_div
		});
	});
	$(function()
	{
		$(".button").corner();
		$(".free").corner();
		$("a.title").flatshadow({
			fade: true
		});
		var t1 =  $('td.one').width();
		var t2 =  $('td.two').width();
		var w = $(window).width();
		var width_div = 0;
		if (w > 600)
		{
			width_div = w/2 - (t1 + t2)/2;
		}
		$('td.space').css({
			width : width_div
		});
		set_button_size();
	});
	function check(checkList)
	{
		var result = false;
		if (button == 'change')
		{
			var judge = true;
			var checkListArray = checkList.split(",");
			var pass = '<?php echo $pass; ?>';
			var isenpty = false;
			for (var i = 0 ; i < checkListArray.length ; i++ )
			{
				var param = checkListArray[i].split("_");
				if(!inputcheck(param[0],param[1],param[2]))
				{
					judge = false;
				}
				if(document.getElementById(param[0]).value =="")
				{
					judge = false;
					document.getElementById(param[0]).style.backgroundColor 
						= '#ff0000';
					isenpty = true;
				}
			}
			if(isenpty)
			{
				judge = false;
				window.alert('���ڂ���͂��Ă��������B');
			}
			if(document.getElementById('pass').value != pass)
			{
				judge = false;
				document.getElementById('pass').style.backgroundColor 
					= '#ff0000';
				window.alert('���݂̃p�X���[�h�Ɠ��e���قȂ��Ă���܂��B');
			}
			if (document.getElementById('newpass').value !=
				 document.getElementById('passCheck').value)
			{
				judge = false;
				window.alert('�p�X���[�h�Ɗm�F�p�p�X���[�h�̓��e����v���Ă��܂���B');
			}
			result = judge;
		}
		if(button == 'cancel')
		{
			result = true;
		}
		
		return result;
	}
	
	function set_button(buttonName)
	{
		button = buttonName;
	}
--></script>
</head>

<body>
<?php
	$_SESSION['post'] = null;
	$_SESSION['post'] = $_SESSION['pre_post'];
	$_SESSION['pre_post'] = null;
	$columnName = "";
	$judge = false;
	if($_SESSION['editUser']['uid'] != $_SESSION['result_array']['LUSERNAME'])
	{
		$columnName 
			= UserCheck($_SESSION['editUser']['uid'],$_SESSION['editUser']['pass']);
	}
	if ($columnName == "")
	{
		$judge = true;
	}
	else
	{
		$judge = false;
	}
	$checkList = "uid_20_3,pass_20_3,newpass_20_3,passCheck_20_3";
	require_once("f_Button.php");
	$filename = $_SESSION['filename'];
	echo "<form action='pageJump.php' method='post'><div class = 'left'>";
	echo makebutton($filename,'top');
	echo "</div>";
	echo "<div style='clear:both;'></div>";
	echo "</form>";
	if($isexist)
	{
		echo "<div class = 'center'>";
		echo "<a class = 'title'>�Ǘ��ҍX�V�ē���</a>";
		echo "</div><br><br>";
		echo '<form action="listUserJump.php" method="post" 
				onsubmit = "return check(\''.$checkList.'\');">';
		echo "<table><tr><td class = 'space'></td><td class = 'one'>�Ǘ���ID</td>";
		echo '<td class = "two"><input type = "text" size = "30"  name = "uid"  id="uid" value = "'
				.$_SESSION['editUser']['uid'].'" 
				onchange ="return inputcheck(\'uid\',20,3);"></td>';
		if(!$judge)
		{
			echo "<td><a class ='error'>���ɓo�^����Ă��܂��B</a></td>";
		}
		if(!$isexist || !$judge)
		{
			$judge = false;
		}
		else
		{
			$_SESSION['pre_post'] = $_SESSION['post'] ;
			$_SESSION['post']['true'] = true;
		}
		echo "</tr><tr><td class = 'space'></td><td class = 'one'>���݃p�X���[�h</td>";
		echo '<td class = "two"><input type = "password" size = "31" name = "pass"  id="pass" 
				value = "'.$_SESSION['editUser']['pass'].'" 
				onchange ="return inputcheck(\'pass\',20,3);"></td>';
		echo "</tr><tr><td class = 'space'></td><td class = 'one'>�p�X���[�h</td>";
		echo '<td class = "two"><input type = "password" size = "31" name = "newpass" 
				value = "'.$_SESSION['editUser']['newpass'].'" id="newpass" 
				onchange ="return inputcheck(\'newpass\',20,3);"></td>';
		echo "</tr><tr><td class = 'space'></td><td class = 'one'>�m�F�p�p�X���[�h</td>";
		echo '<td class = "two"><input type = "password" size = "31" name = "passCheck"
				 value = "'.$_SESSION['editUser']['passCheck'].'" id="passCheck"
				 onchange ="return inputcheck(\'passCheck\',20,3);"></td>';
		echo "</tr></table>";
		echo "<br>";
		echo "<div class = 'center'>";
		echo '<input type="submit" name = "change" value = "�X�V" 
				class = "free" onClick="set_button(\'change\');">';
		echo "</div>";
	}
	else
	{
		$judge == false;
		echo "<div = class='center'>";
		echo "<a class = 'title'>�Ǘ��ҍX�V�s��</a>";
		echo "</div><br><br>";
		echo "<div class ='center'>
				<a class ='error'>���̒[���ł��łɃf�[�^���폜����Ă��邽�߁A�X�V�ł��܂���B</a>
				</div>";
		echo '<form action="listUserJump.php" method="post" >';
		echo "<div class = 'center'>";
		echo '<input type="submit" name = "cancel" value = "�ꗗ�ɖ߂�" class = "free">';
		echo "</div>";
		echo "</form>";
	}
?>
</body>

<script language="JavaScript"><!--

	window.onload = function(){
		var judge_go = '<?php echo $judge ?>';
		if(judge_go)
		{
			if(confirm("���͓��e����m�F�B\n���X�V���܂�����낵���ł����H\n�ēx�m�F����ꍇ�́u�L�����Z���v�{�^���������Ă��������B"))
			{
				location.href = "./editUserComp.php";
			}
		}
	}
--></script>

</html>