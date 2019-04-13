<?php
include "../mysql/loveService.php";
session_start();
header("Content-type:text/html;charset=utf-8");    //设置编码
$l = new Love();
$l->user_id = $_SESSION['id'];  //点赞者的id
$l->microblog_id = $_GET['id1'];  //点赞微博的id
$l->likename = $_SESSION['username']; //点赞者的用户名
$l->liketime = date("Y-m-d H:i:s"); //点赞时间
$ls = new LoveService();
$total = $ls->checkLove($l);  //函数返回1说明已经点赞过，返回0说明未点赞过

if($total){  //如果点赞过
	echo "<script>alert('一条微博只能点赞一次噢,你的心意TA已经收到啦');
	      location.href='index.php';</script>";
}else{   //如果用户没有点赞过
    $addresult = $ls->addLove($l);  //向点赞表插入数据并更新微博表的点赞数量,成功返回1
} 
if($addresult){
    echo "<script>alert('点赞成功.');location.href='index.php';</script>";
}else{
    echo "<script>alert('点赞失败，请稍后再试');location.href='index.php';</script>";
}
?>