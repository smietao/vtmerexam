<?php
include "comments.php";
class CommentService{
/////////////////////////////////发布评论//////////////////////////////////////////
	function addComment($c){
		$result = 0;
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定符集
		if (strlen($c->content)<=400) {  //判断评论正文长度
		$sql = "insert into comment (content,comment_name,microblog_id,time) values (?,?,?,?)";
		$insert = $mysqli->prepare($sql);	
		$insert->bind_param("ssis",$c->content,$c->comment_name,$c->microblog_id,$c->time);  //插入数据到评论表
		$res=$insert->execute();
		  if($res){  
			  $result = 1;  //发布成功返回1,并更新微博表的评论数量
			  $sql="update microblog set comment_count=comment_count+1 where id=?";
              $update = $mysqli->prepare($sql);
              $update->bind_param("i",$c->microblog_id);
              $update->execute();
		  }else{
			  $result = 2;  //发布失败返回2
		  }
	    }else{
	    	$result = 0; //如果微博正文长度超过200字，返回0
	    }
		return $result;
		$update->close();
	    $insert->close();
		$mysqli->close();
	}  //end addComment
///////////////////////77///根据微博id查询评论详情///////////////////////////////////////
	function idComment($m){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select * from comment where microblog_id=? order by id desc";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i",$m->id);
		$stmt->execute();  
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$c = new Comment();
				$c->content = $row["content"];
				$c->comment_name = $row["comment_name"];
				$c->time = $row["time"];
				array_push($listObj,$c);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}  //end idComment

}//end class
?>