<?php
include "love.php";
class LoveService{
///////////////////////////////判断用户是否点赞过///////////////////////////////////////
	function checkLove($l){
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定定符集
        $sql="select count(*) from love where user_id=? and microblog_id=?";
        $stmt = $mysqli->prepare($sql);	
		$stmt->bind_param("ii",$l->user_id,$l->microblog_id);
		$stmt->execute();
		$stmt->bind_result($total);  
		//$total用来判断用户是否点赞过,为0说明未点赞，为1说明点赞过
        $stmt->fetch();
        return $total;
        $stmt->close();
        $mysqli->close();  
	}//end countLove
////////////////////////////////向点赞表插入数据///////////////////////////////////////
	function addLove($l){
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定定符集
		$sql="insert into love (microblog_id,user_id,likename,liketime) 
		      values (?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("iiss",$l->microblog_id,$l->user_id,$l->likename,$l->liketime);  //$l->liketime居然错这了！！！
		$res=$stmt->execute();
		if ($res) {  //插入成功返回1并增加微博表的点赞数量
		    $result=1;
		    $sql="update microblog set likes=likes+1 where id=?";
		    $stmt = $mysqli->prepare($sql);
		    $stmt->bind_param("i",$l->microblog_id);
		    $stmt->execute();	
		}else{  //插入失败返回0
			$result=0;
		}
		return $result;
		$stmt->close();
        $mysqli->close();  
	}// end addLove
///////////////////////////根据微博id查询点赞详情////////////////////////////////////////
	function idLove($m){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select * from love where microblog_id=? order by id desc";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i",$m->id);
		$stmt->execute();  
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$l = new Love();
				$l->likename = $row["likename"];
				$l->liketime = $row["liketime"];
				array_push($listObj,$l);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}  //end idLove
}// end class
?>