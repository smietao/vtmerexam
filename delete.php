<?php
include "../mysql/microblogService.php";
include "../mysql/userService.php";
header("Content-type:text/html;charset=utf-8");    //设置编码
$m = new Microblog();
$m->id=$_GET['id2'];
$ms = new microblogService();
$result=$ms->deleteMicroblog($m);  //删除成功返回1
if($result){
   echo "<script>alert('删除成功');location.href='users.php';</script>";
}else{
   echo "<script>alert('删除失败，请稍后再试');location.href='users.php';</script>";
}