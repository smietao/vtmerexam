<?php
include '../mysql/userService.php';
include 'myfunction.php';
session_start();
header("content-type:text/html;charset=utf8");
$u = new User();
$u->id = $_SESSION['id'];
$u->username = $_POST['username']; //用户提交的新用户名
$oldname = $_SESSION['username']; //用户之前的用户名
$us = new UserService();
if ($u->username!=$oldname) {  //如果新旧名不一致，则用新用户名查询用户表，判断是否重名
  $row = $us->userInfo($u);  //该函数根据用户名查询用户表，并以数组形式返回结果集
  if ($row) {  //如果$row不为空，说明重名
    echo "<script>alert('修改失败，您修改的用户名已存在，请稍后再试');
          location.href='edit.php';</script>";
    exit;
  }
}

//根据上面的判断，不重名或新旧名一致则判断字数
$myfun = new MyFunction();
$u->hobby=$myfun->str_to($_POST['hobby']);  //字符转换
$u->signature=$myfun->str_to($_POST['signature']); //字符转换

if (strlen($u->signature)>300){
  echo "<script>alert('个性签名字数超过限制，请稍后重试');location.href='edit.php';</script>";
  exit;
}else if (strlen($u->hobby)>150){
  echo "<script>alert('兴趣爱好字数超过限制，请稍后重试');location.href='edit.php';</script>";
  exit;
}else if(strlen($u->username)>60){
  echo "<script>alert('用户名字数超过限制，请稍后重试');
        location.href='edit.php';</script>";
  exit;
}else{  //如果字数都符合标准，那么更新各个数据表的信息
  $_SESSION['username']=$_POST['username'];//更改用户名session的值,以便主页显示
  $u->gender=$_POST["gender"];
  $u->birthday=$_POST['birthday'];
  $u->constellation=$_POST['constellation'];
  $us->updateName($u,$oldname); //更新各表的用户名
  echo "<script>alert('修改成功');location.href='users.php';</script>";
 }
?>