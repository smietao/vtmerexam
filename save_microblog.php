<?php
header("content-type:text/html;charset=utf8");
session_start();
include "../mysql/microblogService.php";
include "../mysql/userService.php";
include 'myfunction.php';
$myfun = new MyFunction();
$m = new Microblog(); //微博表的对象
$m->subject = $_POST["subject"];  //微博主题
$m->content = $myfun->str_to($_POST["content"]);  //字符转换
$m->author = $_SESSION['username'];  //微博作者
$m->last_post_time = date("Y-m-d H:i:s");
$us = new UserService();
$ms = new MicroblogService();
$addResult = $ms->addMicroblog($m); 
   //添加微博 成功添加微博返回1，微博正文字数超过限制返回0，添加失败返回2
if ($addResult==2) {
  echo "<script>alert('发布失败，请稍后再试');
        location.href='add_microblog.php';</script>";
  exit;
}
if ($addResult==0) {
  echo "<script>alert('微博正文超过字数限制，请稍后再试');
        location.href='add_microblog.php';</script>";
  exit;
}
$accResult = $us->accExperience($m);  //累积经验 返回值为1则累积了经验，返回值为0则未累积经验值
if ($addResult&&$accResult) {  //如果这两个变量都不为0说明发布微博成功并累积了经验
  echo "<script>alert('发布成功,经验值+3');location.href='index.php';</script>";
}else{   //否则说明未累积经验值
  echo "<script>alert('发布成功,因经验值已达上限，经验值+0');location.href='index.php';</script>";
    }
?>