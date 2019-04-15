<?php
 include "../mysql/applyService.php";
 session_start();
 $a = new Apply();
 $a->flag = $_GET['flag'];
 $a->applyname = $_GET['applyname'];
 $a->friendname = $_SESSION['username'];
 $as = new ApplyService();
 $result = $as->dealApply($a);
 if ($result) {
 	echo "<script>alert('操作成功');
        location.href='users.php';</script>";
    exit;
 }else{
 	echo "<script>alert('操作失败');
        location.href='users.php';</script>";
 }
?>