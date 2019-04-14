<!DOCTYPE html>
<html>
<head>
	<title>模糊查询</title>
	<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
include "../mysql/microblogService.php";
include 'myfunction.php';
session_start();
header("Content-type:text/html;charset=utf-8");    //设置编码
$manage = $_SESSION['manage'];  //判断是否为管理员
$m = new Microblog();
$m->content = $_POST['content'];
  echo "<h3>微博列表</h3>"; 
$ms = new MicroblogService();
$m_list = $ms->contentMicroblog($m);  //根据微博主题查询微博表的内容
if($m_list!=null){
  $myfun = new MyFunction();
  $myfun->showMicroblog($m_list,$manage);  //显示微博，$manage用于判断是否出现删除按键
}else{
		echo "对不起，查找不到您输入的内容，感谢您的关注......";
	}
?>
<h4 align="center"><a href="index.php">返回首页</a></h4>
</body>
</html>