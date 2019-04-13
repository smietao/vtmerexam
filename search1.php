<!DOCTYPE html>
<html>
<head>
	<title>分页显示微博</title>
	<meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h2>微博列表</h2>
<?php
include "../mysql/userService.php";
include "../mysql/microblogService.php";
include "myfunction.php";
header("content-type:text/html;charset=utf8");
session_start();
$limit = $_SESSION['limit'];  //判断是否出现删除按键
$manage = $_SESSION['manage'];  //判断是否为管理员
$u = new User();
$u->username = $_SESSION['be_name'];  //被访者名称
$page = $_GET['page']; //当前页数
$ms = new MicroblogService();
$m_list = $ms->userMicroblog($u,$page*3-3); //查询用户的微博,该函数返回一个数组
$myfun = new MyFunction();
if ($manage) {  //如果是管理员
	$myfun->showMicroblog($m_list,$manage);  //显示微博,并有删除功能
}else{  //如果不是管理员
$myfun->showMicroblog($m_list,$limit);  //显示微博，没有删除功能
}
$count=$ms->countMicroblog($u); //查询微博数量
$ms->showPage($page,$count);  //显示分页 
?>