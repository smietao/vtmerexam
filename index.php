<!DOCTYPE html>
<html>
<head>
	<title>雨点微博</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
 <h2>欢迎来到雨点微博</h2>	
 <img src="yu.jpg" width="280" height="190">
 <br>

 <?php
 include "../mysql/microblogService.php";
 include "../mysql/userService.php";
 include "myfunction.php";
 header("Content-type:text/html;charset=utf-8");    //设置编码
 session_start();
 $manage = $_SESSION['manage'];
 if ($manage) {  //如果是管理员
    echo "<管理员>";
  } 
 echo $_SESSION['username'].",Welcome back to microblog".
      '<span class="fh"><a href="users.php">个人中心</a></span>';//欢迎用户，显示个人中心
 ?>	  
 <h3>在这里你可以畅所欲言：
  <a href="add_microblog">发布微博</a>
 </h3>
 <h3>
  <form action="subject.php" method="post">微博主题:
    <select name="subject" class="input">
 	    <option value="体育">体育</option>
 	    <option value="数码">数码</option>
 	    <option value="情感">情感</option>
 	    <option value="游戏">游戏</option>
 	    <option value="搞笑">搞笑</option>
 	    <option value="科学技术">科学技术</option>
 	    <option value="个人生活">个人生活</option>
    </select>
    <input type="submit" name="submit" class="btn" value="查看">
   </form>
 </h3>
 <h3>
    <form action="search.php" method="post">查找用户：
        <input type="text" name="username" size="15">
        <input type="submit" name="submit" class="btn" value="搜索">
    </form>
 </h3>
 <h2>微博列表:</h2>
<?php
$u= new User();
$u->id=$_SESSION['id'];
$us = new UserService();
$us->updateGrade($u);
$ms = new MicroblogService();
$m_list = $ms->microblogList();//查询微博表内容
if($m_list!=null){
    $myfun = new MyFunction();
    $myfun->showMicroblog($m_list,$manage);  //显示微博，$manage用于判断是否出现删除按键
}else{
		echo "对不起，微博目前还没有用户入驻，感谢您的关注......";
	}
?>
</body>
</html>