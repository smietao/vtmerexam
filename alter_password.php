<?php
include '../mysql/userService.php';
session_start();
header("Content-type:text/html;charset=utf-8"); //设置编码
$u = new User();
$u->id = $_SESSION['id'];
$u->password = md5($_POST['oldpassword']);
$us = new userService();
$count = $us->checkPass($u);  //检查旧密码，如果为1，说明旧密码正确
if (!$count) {   //如果旧密码不正确
	echo "<script>
  	      alert('您输入的旧密码不正确，请稍后重试');location.href='change.html';</script>";
	exit;
}else{
	$u->password = md5($_POST['newpassword']);
	$count = $us->checkPass($u);  //检查新密码，如果为1，说明新密码与旧密码重复
}

if ($count) {
	echo "<script>alert('您输入的新密码和旧密码相同，请稍后重试');
	      location.href='change.html';</script>";
	exit;
}else{  //通过验证，修改密码
    $result=$us->updatePass($u);  //修改密码，成功返回1
    if ($result) {
        echo "<script>alert('修改成功，请重新登录');location.href='login.html';</script>";
    }else{
    	echo "<script>alert('修改失败，请稍后重试');location.href='change.html';</script>";
    }
}
?>