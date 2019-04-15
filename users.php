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
 include "../mysql/applyService.php";
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
$myfun->showUser($row,1); //显示用户个人信息

$sum=$us->visitorCount($u);  //返回访客数量
if($sum){
    echo '<h3 align="center">访客数量:'.$sum.'<span class="centre">
       <a style="color: brown" href="visit.php">[谁看过我]<a></span></h3>';
}else{
    echo "<h3>您的主页暂时没有访客噢.</h3>";
}

$as = new ApplyService();
$a_list = $as->selectApply($u); //查询申请信息，如果有好友申请，则显示出来
if($a_list!=null){
  foreach ($a_list as $a) {
  if (!$a->flag) {   //如果flag为0说明还不是好友，显示好友申请
  echo "用户<q>".$a->applyname."</q>申请添加好友";   
  $applyname = $a->applyname;  //用于查询apply表
  ?>
   <a class="spa" href="deal_apply.php?
   flag=1&&applyname=<?php echo $applyname ?>">[同意]</a>
   <a class="spa" href="deal_apply.php?
   flag=0&&applyname=<?php echo $applyname ?>">[拒绝]</a><br>
<?php 
       } //end if
    } //end foreach
 }//end if
?>
<h3 align="center"><a href="friend.php">好友列表</a></h3>
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
