<?php
include '../mysql/userService.php';
session_start();
header("Content-type:text/html;charset=utf-8");
$u = new User();
$u->account = $_POST['account'];
$u->password=md5($_POST['password']);
if($u->account==''){
	echo "<script>alert('请输入账号');'</script>";
	exit;
}
if($u->password==''){
	echo "<script>alert('请输入密码');</script>";
	exit;
}
$us = new UserService();
$row = $us->checkLogin($u);

if($row){
	if($u->password !=($row['password']) ){
		echo "<script>alert('密码错误，请重新输入');location.href='login.html'</script>";
	    exit;
    }else{
    	$_SESSION['username']=$row['username'];
    	$_SESSION['account']=$row['account'];
    	$_SESSION['id']=$row['id'];
    	$_SESSION['manage']=$row['manage'];
    	echo "<script>alert('登录成功');location.href='index.php'</script>";
    }
}else{
	echo "<script>
	alert('您输入的账号或邮箱不存在，请重新输入或前往注册');
	location.href='login.html'</script>";
	exit;
}
?>