<?php
include "../mysql/microblogService.php";
include "../mysql/userService.php";
include "../mysql/commentService.php";
include 'myfunction.php';
header("Content-type:text/html;charset=utf-8");    //设置编码
session_start();
$myfun = new MyFunction();

$m = new Microblog();
$m->id=$_SESSION['id1']; //微博id
$m->author=$_SESSION['username']; //评论的用户名赋值给m对象，用于累积经验值

$c = new Comment();
$c->comment_name=$_SESSION['username']; // 评论的用户名
$c->content=$myfun->str_to($_POST['reply']);  // 回复内容,并字符转换
$c->time=date("Y-m-d H:i:s"); //回复时间
$c->microblog_id=$_SESSION['id1'];  //微博id

$cs = new CommentService();
$addResult=$cs->addComment($c);  //储存评论内容，成功返回1，评论内容过长返回0，失败返回2

  if($addResult==2){  //如果评论失败
      echo "<script>alert('评论失败,请稍后重试');
      location.href='reply.php?id=$m->id';</script>";
      exit;
  }else if($addResult==0){  //如果评论内容过长
      echo "<script>alert('评论内容超过字数限制，请稍后再试');
      location.href='reply.php?id=$m->id';</script>";
      exit;
      }

  if($addResult==1){  //如果存储评论内容成功
      $us = new UserService();
      $accResult=$us->accExperience($m);  //评论累积经验，成功返回1，累积失败返回0
      if ($accResult==1) {  //如果为1说明累积了经验值
           echo "<script>alert('评论成功，经验值+3');location.href='index.php';</script>";
      }else{  //否则没有累积经验值
            echo "<script>alert('评论成功,因经验值已达上限，经验值+0');location.href='index.php';</script>";
      }
  }

?>