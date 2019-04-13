<!DOCTYPE html>
<html>
<head>
  <title>评论中心</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h3 align="center">微博</h3>
<?php 
include "../mysql/microblogService.php";
include "../mysql/userService.php";
include "../mysql/commentService.php";
include "myfunction.php";
session_start();
$m = new Microblog();
$m->id = $_GET['id'];  //微博id
$ms = new MicroblogService();
$m_list = $ms->idMicroblog($m);  //返回这条微博的查询结果
$myfun = new MyFunction();
$myfun->showMicroblog($m_list,0);  //显示微博 
?>

<table width="60%" border="1" cellpadding="12" cellspacing="0" align="center">
      <caption><h3 style="color:brown ">评论详情</h3></caption>
      <tr class="bg">
        <th>用户名</th>
        <th>评论内容</th>
        <th>评论时间</th>  
      </tr>
<?php
$cs = new CommentService();
$c_list = $cs->idComment($m);  //根据微博id查询comment表的内容
if($c_list!=null){
	foreach ($c_list as $c) {//  循环输出评论详情
?> 
        <tr>
			    <td width="20%">
            <?php echo $c->comment_name; ?>
          </td>
          <td width="50%">
            <?php echo $c->content; ?>
          </td>
          <td width="30%">
            <?php echo $c->time;?>
          </td>
        </tr>
<?php
      }//foreach语句的右括号
    }//if语句的右括号
  echo "</table>";
?>
<p align="center">
  <a href="javascript:history.back(-1)">返回上一页</a>
</p>
<p align="center">
  <a href="index.php">返回首页</a>
</p>
</body>
</html>