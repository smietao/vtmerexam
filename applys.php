<?php
session_start();
include "../mysql/applyService.php";
$be_name = $_SESSION['be_name']; //用于跳回搜索页面
$a = new Apply();
$a->apply_id = $_SESSION['id'];  //申请添加好友的用户id
$a->be_id = $_GET['be_id'];  //被申请好友的用户id
$a->applyname = $_SESSION['username']; //申请添加好友的用户名
$a->friendname = $_SESSION['be_name']; //被申请添加好友的用户名
$as = new ApplyService();
$count = $as->checkApply($a);  //检查是否申请过添加好友，如果为1说明申请过，0说明未申请过
if ($count) {
	echo "<script>alert('您已提交过申请，请勿重复申请');
      location.href='search.php?username=$be_name';</script>";
      exit;
}else{
	$resuit = $as->addApply($a);  //向申请表中插入内容
	if ($resuit) {
		echo "<script>alert('申请添加好友成功，请等待对方的同意');
      location.href='search.php?username=$be_name';</script>";
      exit;
	}else{
		echo "<script>alert('申请失败');
      location.href='search.php?username=$be_name';</script>";
      exit;
	}
}
?>