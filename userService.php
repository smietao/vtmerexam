<?php
include "user.php";
class UserService{
//////////////////////////////////更新用户等级////////////////////////////////////////////
	function updateGrade($u){
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select experience from user where id=$u->id";
		$result=$mysqli->query($sql);
    $row=mysqli_fetch_array($result);
    if ($row['experience']>=2000&&$row['experience']<5000) {
      	$sql="update user set grade=5 where id=$u->id";
      	$mysqli->query($sql);
      }else if($row['experience']>=1000){
      	$sql="update user set grade=4 where id=$u->id";
      	$mysqli->query($sql);
      }else if($row['experience']>=300){
      	$sql="update user set grade=3 where id=$u->id";
      	$mysqli->query($sql);
      }else if($row['experience']>=100){ 
      	$sql="update user set grade=2 where id=$u->id";
      	$mysqli->query($sql);
      }
    $mysqli->close();
    }//end updateGrade
///////////////////////////////////////积累经验////////////////////////////////////////////
  function accExperience($m){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="select experience from user where username=?";
    $select = $mysqli->prepare($sql);
    $select->bind_param("s",$m->author);
    $select->execute();
    $select->bind_result($res);  //$res为用户的经验值
    $select->fetch();
    $resu=0; //先定义$resu,用于判定是否增加了经验值,默认为没有增加经验值
    if ($res<=4997){//如果经验值还没到顶，则发微博加经验值
    $sql="update user set experience=experience+3 where username=?";
    $update = $mysqli->prepare($sql);
    $update->bind_param("s",$m->author);
    $resu = $update->execute();
    }
    if ($resu) {    //判断是否增加了经验值
      $result=1;   //增加了经验值，返回1
    }else{  //没有增加经验值，返回0
      $result=0;
    }
    return $result;
    $select->close();
    $update->close();
    $mysqli->close();
    }//end accExperience
///////////////////根据用户账号查询用户信息，用于检查登录//////////////////////////////////
  function checkLogin($u){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="select id,email,account,username,password,manage from user 
          where account=? or email=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$u->account,$u->account);  
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    return $row;
    $stmt->close();
    $mysqli->close();
    }//end checkLogin
//////////////////////////////根据用户id查询访客数量/////////////////////////////////////
  function visitorCount($u){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="select visitor_count from user where id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$u->id);  //第二次错，哭。。。
    $stmt->execute();
    $stmt->bind_result($num);
    $stmt->fetch();
    return $num;
    $stmt->close();
    $mysqli->close();
    }//end visitorCount
///////////////////////////////根据用户名查询用户信息/////////////////////////////////////
  function userInfo($u){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="select * from user where username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s",$u->username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    return $row;
    $stmt->close();
    $mysqli->close();
    }//end userInfo
///////////////////////////////////注册时插入用户信息////////////////////////////////////
  function addUser($u){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="insert into user (account,username,password,email,log_time) VALUES
    (?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss",$u->account,$u->username,$u->password,$u->email,$u->log_time);
    $res=$stmt->execute();
    if ($res) {
      $result = 1;
    }else{
      $result = 0;
    }
    return $result;
  }//end addUser
///////////////////////////////////检查注册////////////////////////////////////
  function checkUser($u){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="select email,account,username from user 
          where account=? or email=? or username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss",$u->account,$u->email,$u->username);  
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    return $row;
    $stmt->close();
    $mysqli->close();
    }//end checkUser
////////////////////////////////编辑资料更新用户名///////////////////////////////////////
    function updateName($u,$oldname){
    $mysqli = new mysqli("localhost","root","","mydb");
    $mysqli->set_charset('utf8');//设定字符集
    $sql="update user set
    username=?,gender=?,birthday=?,hobby=?,constellation=?,signature=? WHERE id=?";
    //更新用户表
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssssi",$u->username,$u->gender,$u->birthday,$u->hobby,$u->constellation,$u->signature,$u->id);
    $stmt->execute();
    $sql=$sql="update microblog set author=? where author=?";  //更新微博表
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$u->username,$oldname);
    $stmt->execute();
    $sql="update comment set comment_name=? where comment_name=?"; //更新评论表
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$u->username,$oldname);
    $stmt->execute();
    $sql="update visitor set visitorname=? where visitorname=?";  //更新访客表
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$u->username,$oldname);
    $stmt->execute();
    $sql="update love set likename=? where likename=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$u->username,$oldname);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
  }//end updateName
  }//end class
?>