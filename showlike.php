<!DOCTYPE html>
<html>
<head>
  <title>点赞中心</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h3 align="center">微博</h3>
<?php 
include "../mysql/microblogService.php";
include "../mysql/loveService.php";
include "myfunction.php";
session_start();
$m = new Microblog();
$m->id = $_GET['id'];  //微博id
$ms = new MicroblogService();
$m_list = $ms->idMicroblog($m);  //返回这条微博的查询结果
$myfun = new MyFunction();
$myfun->showMicroblog($m_list,0);  //显示微博，0代表没有删除按键
?>

<table width="60%" border="1" cellpadding="12" cellspacing="0" align="center">
      <caption><h3 style="color:brown ">点赞详情</h3></caption>
      <tr class="bg">
       <th>点赞用户名</th>
       <th>点赞时间</th>  
      </tr>
<?php
$ls = new LoveService();
$l_list = $ls->idLove($m);  //根据微博id查询love表的内容
if($l_list!=null){
  foreach ($l_list as $l) {//  循环输出点赞详情
?>
        <tr>
			    <td width="50%">
            <?php echo $l->likename; ?>
          </td>
          <td width="50%">
            <?php echo $l->liketime;?>
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