<?php
include '../mysql/userService.php';
header("Content-type:text/html;charset=utf-8"); //设置编码
$u = new User();
$u->account=$_POST['account'];
$u->username=$_POST['username'];
$u->password=md5($_POST['password']);
$u->email=trim($_POST['email']);
$u->log_time=date("Y-m-d H:i:s");

$us = new UserService();
$row = $us->checkUser($u);  //根据注册的账号和邮箱查询用户表，判断账号和邮箱是否已经被注册
if (strlen($row['username'])>30) {  //如果用户名长度超过限制
  	echo "<script>
  	      alert('用户名长度超过限制,请重新注册');location.href='reg.html';</script>";
	exit;
  }  
if($row['account']==$u->account){
	echo "<script>alert('账号已经被注册,请重新注册');location.href='reg.html';</script>";
	exit;
}else if($row['email']==$u->email){
	echo "<script>alert('邮箱已经被注册,请重新注册');location.href='reg.html';</script>";
	exit;
}else if($row['username']==$u->username){
    echo "<script>alert('用户名已经被注册,请重新注册');location.href='reg.html';</script>";
    exit;
}else{
	$result = $us->addUser($u);  //插入注册信息，成功返回1
}
if($result) {
	$_SESSION['account']=$u->account;
    echo "<script>alert('注册成功，前往登录');location.href='login.html';</script>";
}else{
    echo"<script>alert('注册失败，请重新注册');location.href='reg.html';</script>";
}
?>