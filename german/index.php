<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>聯合書目查詢</title>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="noindex">
	<link type="text/css" href="./css/reset.css" rel="stylesheet" media="all" />
	<style>
		.fromGerman,.fromMH{
			border:#000000 1px solid; 
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			padding:20px;
			margin:10px;
			width:70%;
		}
		f{
			font-size:0.8em;
			color:#E353AF;
		}
		a {
			color: #08C;
			text-decoration: none;
		}
		s{
			text-decoration: none;
		}
		p{
			line-height:28px;
		}
		.red{
			color:red;
		}
	</style>
	<script type="text/javascript" src="./js/jquery-1.8.0.min.js"></script>
	<?php
		echo '<script>';
		if(!empty($_GET['selectColumn'])){
			echo 'var selectColumn="',htmlspecialchars($_GET['selectColumn']),'";';
			echo 'var searchStr="',htmlspecialchars($_GET['searchStr']),'";';
		}else
			echo 'var selectColumn="";';
		echo '</script>';
	?>
	<script>
	$(function(){
		if(selectColumn){
			$('#searchStr').val(searchStr);
			$('#selectColumn').val(selectColumn);
			$('#showResult').html('<img src="./img/ajax-loader.gif"/>');
			$('#tmpArea').load('givebooks.php',{selectColumn:selectColumn,searchStr:searchStr},function(){
				$('#showResult').html('');
			});
		}
	});
	</script>

</head>

<body>
	<form action="index.php" method="get">
		<p>尋找 Find 
		<select id="selectColumn" name="selectColumn">
			<option value="titleInfo-title">書名 Bookname</option>
			<option value="name">作者 Author</option>
			<option value="originInfo-place-placeTerm">出版地 publishplace</option>
			<option value="originInfo-publisher">出版社 publisher</option>
			<option value="originInfo-dateIssued">出版年 publishTime</option>
		</select>
		<input type="text" name="searchStr" id="searchStr" /></p>
		<input type="submit" value="搜尋 Search" />
	</form>
	<div id="showResult">
	
	</div>
	<div id="tmpArea">
		
	</div>
</body>
</html>
