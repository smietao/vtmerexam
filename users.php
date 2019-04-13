<!DOCTYPE html>
<html>
<head>
	<title>个人中心</title>
	<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2 align="center">个人中心</h2>
<?php
 include "../mysql/microblogService.php";
 include "../mysql/userService.php";
 include "myfunction.php";
session_start();
$_SESSION['limit'] = 1; //1表示有删除功能
$page = 0; //用于分页查询
$limit = 1; //为1则显示删除按钮
$u = new User();
$u->id=$_SESSION['id'];
$u->username=$_SESSION['username'];
$_SESSION['be_name']=$_SESSION['username']; //用于分页显示微博的查询条件
$us = new UserService();
$row=$us->userInfo($u); //查询用户信息，返回数组$row
$myfun = new MyFunction();
$myfun->showUser($row,1);
$sum=$us->visitorCount($u);  //返回访客数量
if($sum){
    echo '<h3 align="center">访客数量:'.$sum.'<span class="centre">
       <a style="color: brown" href="visit.php">[谁看过我]<a></span></h3>';
}else{
    echo "<h3>您的主页暂时没有访客噢.</h3>";
}
?>
<h2 align="center" style="color: grey">Your Microblog</h2>
<?php
$ms = new MicroblogService();
$m_list = $ms->userMicroblog($u,$page); //查询用户的微博,该函数返回一个数组
if($m_list!=null){
  $myfun->showMicroblog($m_list,$limit);  //显示微博
  $count=$ms->countMicroblog($u); //查询微博数量
  $ms->showPage($page+1,$count);  //显示分页 
}else{
		echo "对不起，您暂时还没有发过微博噢。";
	}
?>
</body>
</html>
