<?php
include "visitor.php";
class VisitorService{
//////////////////////////////////检查用户是否访问过//////////////////////////////////////
	function checkVisit($v){
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定定符集
        $sql="select count(*) from visitor where visitor_id=? and be_id=?";
        $stmt = $mysqli->prepare($sql);	
		$stmt->bind_param("ii",$v->visitor_id,$v->be_id);
		$stmt->execute();
		$stmt->bind_result($total);  
		//$total用来判断用户是否访问过,为0说明未访问过，为1说明访问过
        $stmt->fetch();
        return $total;
        $stmt->close();
        $mysqli->close();
	}//end checkVisit
//////////////////////////////////插入访问信息///////////////////////////////////////
	function addVisit($v,$total){
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定定符集
		$sql="insert into visitor (visitorname,visitor_id,be_id,time) 
             values (?,?,?,?)";//插入访问信息
		$stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("siis",$v->visitorname,$v->visitor_id,$v->be_id,$v->time);  
		$res=$stmt->execute();
		if (!$total) {  //如果未访问过,则更新用户表的访问数量
		    $sql="update user set visitor_count=visitor_count+1 where id=?";
		    $stmt = $mysqli->prepare($sql);
		    $stmt->bind_param("i",$v->be_id);
		    $stmt->execute();	
		}
		return $total;
		$stmt->close();
        $mysqli->close();  
	}// end addVisit
////////////////////////////////根据用户id查询访问记录///////////////////////////////////
	function showVisit($v){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定定符集
		$sql="select visitorname,time from visitor where be_id=? order by id desc";
		$stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("i",$v->be_id);  
		$stmt->execute();
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$v1 = new Visitor();
				$v1->visitorname = $row["visitorname"];
				$v1->time = $row["time"];
				array_push($listObj,$v1);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}
}//end class
?>