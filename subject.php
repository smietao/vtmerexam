<!DOCTYPE html>
<html>
<head>
	<title>主题微博</title>
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
$m->subject = $_POST['subject'];
  echo "<h3>".$m->subject."主题:</h3>"; 
$ms = new MicroblogService();
$m_list = $ms->subjectMicroblog($m);  //根据微博主题查询微博表的内容
if($m_list!=null){
  $myfun = new MyFunction();
  $myfun->showMicroblog($m_list,$manage);  //显示微博，$manage用于判断是否出现删除按键
}else{
		echo "对不起，该主题暂时没有内容，感谢您的关注......";
	}
?>
<h4 align="center"><a href="index.php">返回首页</a></h4>
</body>
</html>