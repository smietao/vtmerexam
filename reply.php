<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>评论微博</title>
 <link rel="stylesheet" type="text/css" href="add.css">
</head>
<body>
<?php 
session_start();
$_SESSION['id1']=$_GET['id'];//将评论的微博的id用session保存，方便在save文件中更新微博表
?>
<form action="save_reply.php" method="post">
  <table width="500px" cellspacing="0" cellpadding="8" align="center">
    <tr id="title">
	  <td colspan="2" style="background-color: #B10707">
	  	发表评论 <span class="right">[<a href="index.php">返回首页</a> ]</span>
	  </td>
	</tr>
	
	<tr>
	  <td><strong>评论内容(100字以内)</strong></td>
	  <td><textarea name="reply" cols="40" rows="10"></textarea></td>
	</tr>

	<tr>
	  <td colspan="2" align="center">
	  	<input type="submit" name="submit" class="btn" value="发布">
	  	<input type="reset" name="submit2" class="btn" value="重置">
	  </td>
	</tr>
  </table>
</form>
</body>
</html>