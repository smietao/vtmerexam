<!DOCTYPE html>
<html>
<head>
	<title>搜索用户及其微博</title>
	<meta charset="UTF-8"> 
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include "../mysql/visitorService.php";
include "../mysql/userService.php";
include "../mysql/microblogService.php";
include "myfunction.php";
header("content-type:text/html;charset=utf8");
session_start();
$_SESSION['limit'] = 0; //没有删除按钮
$manage = $_SESSION['manage']; //判断是否为管理员
$page = 0;
$u = new User();
$u->username = $_GET['username']; //被访者的用户名，用于查询被访者的id
$us = new UserService();
$row = $us->userInfo($u); //该函数以数组形式返回用户信息
$_SESSION['be_name'] = $_GET['username'];  //记录被访者姓名

if($row){
   //记录访问信息
   $v = new Visitor();
   $v->visitor_id = $_SESSION['id']; //访客id
   $v->visitorname = $_SESSION['username']; //访客名
   $v->time = date("Y-m-d H:i:s");  //访问时间
   $v->be_id = $row['id']; //被访者的id
   $myfun = new MyFunction();
   $myfun->showUser($row,0);   //显示用户资料，0代表表格没有编辑资料和注销登录按键
}else{
    echo "<script>alert('您搜索的用户名不存在，请稍后重试');location.href='index.php';</script>";
}
if ($u->username!=$_SESSION['username']) {  
//如果被访者不是用户自己，显示添加好友  ?>
<a href="applys.php?be_id=<?php echo $v->be_id //将被访者的id传出 ?>">[添加好友]</a>
<?php  }
$ms = new MicroblogService();
$m_list = $ms->userMicroblog($u,$page); //查询用户的微博,该函数返回一个数组,$page用于分页
echo '<h3 align="center">'.'<q>'.$u->username.'</q>'."的历史微博：</h3>";
  if($m_list!=null){  //如果数组不为空
  $myfun->showMicroblog($m_list,$manage);  //显示微博，0代表没有删除,1代表有删除    
    }else{
		echo "对不起，".$u->username."目前还没有发过微博，感谢您的关注......";
	}
?>

<?php     //开始写有关访客数量的代码
  $vs = new VisitorService();
  $total = $vs->checkVisit($v);  //检查是否访问过，访问过返回1，未访问过返回0
  $vs->addVisit($v,$total); //添加访问信息

  $count=$ms->countMicroblog($u); //查询微博数量
  $ms->showPage($page+1,$count);  //显示分页 
?>
</body>
</html>