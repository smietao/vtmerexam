<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>发微博</title>
	<link rel="stylesheet" type="text/css" href="add.css">
</head>
<body>
	<form action="save_microblog.php" method="post">
		<table width="500px" cellspacing="0" cellpadding="8" align="center">
			<tr id="title">
				<td colspan="2" style="background-color: #B10707">发布微博 
					<span class="right">[<a href="index.php">返回首页</a> ]</span>
				</td>
			</tr>
			<tr>
				<td width="23%"><strong>微博主题</strong></td>
				<td width="77%"><select name="subject" class="input">
					<option value="体育">体育</option>
					<option value="数码">数码</option>
					<option value="情感">情感</option>
					<option value="游戏">游戏</option>
					<option value="搞笑">搞笑</option>
					<option value="科学技术">科学技术</option>
					<option value="个人生活">个人生活</option>
				</select></td>
			</tr>
			<tr>
				<td><strong>微博正文(200字以内)</strong></td>
				<td><textarea name="content" cols="50" rows="15"></textarea></td>
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