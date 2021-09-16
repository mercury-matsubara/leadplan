<?php
	session_start(); 
	header('Expires:-1'); 
	header('Cache-Control:'); 
	header('Pragma:'); 
        header('Content-type: text/html; charset=Shift_JIS'); 
	require_once("f_Construct.php");
	require_once("f_Button.php");
	require_once("f_DB.php");
	require_once("f_Form.php");
	start();
	$form_ini = parse_ini_file('./ini/form.ini', true);
	$_SESSION['post'] = $_SESSION['pre_post'];
	$filename = $_SESSION['filename'];
	$title = 'ç›å…åv';
?>
<!DOCTYPE html PUBLIC "-//W3C/DTD HTML 4.01">
<!-- saved from url(0013)about:internet -->
<!-- 
*------------------------------------------------------------------------------------------------------------*
*                                                                                                            *
*                                                                                                            *
*                                          ver 1.0.0  2014/05/09                                             *
*                                                                                                            *
*                                                                                                            *
*------------------------------------------------------------------------------------------------------------*
 -->

<html>
<head>
<title><?php echo $title ; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<link rel="stylesheet" type="text/css" href="./list_css.css">
<script src='./jquery-1.8.3.min.js'></script>
<script src='./jquery.corner.js'></script>
<script src='./jquery.flatshadow.js'></script>
<script src='./button_size.js'></script>
<script language="JavaScript"><!--
	history.forward();
	$(window).resize(function()
	{
		var t =  $('table.list').width();
		var w = $(window).width();
		var width_div = 0;
		if (w > 600)
		{
			width_div = w/2 - (t)/2;
		}
		$('div#space').css({
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
		var t =  $('table.list').width();
		var w = $(window).width();
		var width_div = 0;
		if (w > 600)
		{
			width_div = w/2 - (t)/2;
		}
		$('div#space').css({
			width : width_div
		});
		set_button_size();
	});
--></script>
</head>
<body>

<?php
	$zaikokei = array();
	$zaikokei = make_zaikokei();
	$SOUGOUKEI = $zaikokei[3] + $zaikokei[4] + $zaikokei[5] + $zaikokei[6] + $zaikokei[7];
	$_SESSION['zaikokei'] = $zaikokei;
	$_SESSION['zaikokei'][8] = $SOUGOUKEI;
	echo "<form action='pageJump.php' method='post'><div class = 'left'>";
	echo makebutton($filename,'top');
	echo "</div>";
	echo "<div style='clear:both;'></div>";
	echo "<div class = 'center'><br><br>";
	echo "<a class = 'title'>".$title."</a><br><br>";
	echo "</div><div class = 'left' id = 'space'>Å@</div><div class = 'left'>";
	echo "<table class = 'list'><tr>";
	echo "<td id='stripe' class = 'left'><a class= 'itemname'>ç›å…ëçêî(ë‰)</a></td>";
	echo "<td id='stripe' class = 'center'><a class= 'comp'>".$zaikokei[0]."</a></td></tr>";
	echo "<tr>";
	echo "<td class = 'left'><a class= 'itemname'>ç≈å√çwì¸ì˙ït</a></td>";
	$zaikokei[1] = format_change(1,$zaikokei[1],1);
	echo "<td class = 'left'><a class= 'comp'>".$zaikokei[1]."</a></td></tr>";
	echo "<tr>";
	echo "<td id='stripe' class = 'left'><a class= 'itemname'>ç≈å√îNéÆ</a></td>";
	echo "<td id='stripe' class = 'left'><a class= 'comp'>".$zaikokei[2]."</a></td></tr>";
	echo "<tr>";
	echo "<td class = 'left'><a class= 'itemname'>ëçóééDé‘óºâøäi(â~)</a></td>";
	$zaikokei[3] = format_change(3,$zaikokei[3],1);
	echo "<td class = 'right'><a class= 'comp'>".$zaikokei[3]."</a></td></tr>";
	echo "<tr>";
	echo "<td id='stripe' class = 'left'><a class= 'itemname'>ëçè¡îÔê≈(â~)</a></td>";
	$zaikokei[4] = format_change(3,$zaikokei[4],1);
	echo "<td id='stripe' class = 'right'><a class= 'comp'>".$zaikokei[4]."</a></td></tr>";
	echo "<tr>";
	echo "<td class = 'left'><a class= 'itemname'>ëçÉäÉTÉCÉNÉãóaëıã‡(â~)</a></td>";
	$zaikokei[5] = format_change(3,$zaikokei[5],1);
	echo "<td class = 'right'><a class= 'comp'>".$zaikokei[5]."</a></td></tr>";
	echo "<tr>";
	echo "<td id='stripe' class = 'left'><a class= 'itemname'>ëçóééDóø(â~)</a></td>";
	$zaikokei[6] = format_change(3,$zaikokei[6],1);
	echo "<td id='stripe' class = 'right'><a class= 'comp'>".$zaikokei[6]."</a></td></tr>";
	echo "<tr>";
	echo "<td class = 'left'><a class= 'itemname'>ëçé©ìÆé‘ê≈(â~)</a></td>";
	$zaikokei[7] = format_change(3,$zaikokei[7],1);
	echo "<td class = 'right'><a class= 'comp'>".$zaikokei[7]."</a></td></tr>";
	echo "<tr>";
	echo "<td id='stripe' class = 'left'><a class= 'itemname'>ëççáåv(â~)</a></td>";
	$SOUGOUKEI = format_change(3,$SOUGOUKEI,1);
	echo "<td id='stripe' class = 'right'><a class= 'comp'>".$SOUGOUKEI."</a></td></tr>";
	echo "</table>";
	echo "</form>";
	echo "<form action='download_csv.php' method='post'>";
	echo "<input type ='submit' name = 'csv' class='button' value = 'csvÉtÉ@ÉCÉãê∂ê¨' style ='height:30px;' >";
	echo "</form>";
	echo "</div>";
?>

</body>

</html>
