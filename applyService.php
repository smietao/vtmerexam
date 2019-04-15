<?php
include 'apply.php';
class ApplyService{
///////////////////////////////检查是否已经申请过添加好友/////////////////////////////////////
    function checkApply($a){
	$mysqli = new mysqli("localhost","root","","mydb");
	$mysqli->set_charset('utf8');//设定定符集
	$sql="select count(*) from apply where apply_id=? and be_id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii",$a->apply_id,$a->be_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
        $stmt->close();
        $mysqli->close();
	}//end checkApply
    function addApply($a){
	$mysqli = new mysqli("localhost","root","","mydb");
	$mysqli->set_charset('utf8');//设定定符集
	$sql="insert into apply (apply_id,be_id,applyname,friendname) values (?,?,?,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iiss",$a->apply_id,$a->be_id,$a->applyname,$a->friendname);
        $res = $stmt->execute();
        return $res;
        $stmt->close();
        $mysqli->close();
	}//end addApply
///////////////////////////////////////查询申请信息////////////////////////////////////////
    function selectApply($u){
        $listObj = array();
        $mysqli = new mysqli("localhost","root","","mydb");
        $mysqli->set_charset('utf8');//设定字符集
        $sql="select applyname,flag,friendname from apply where be_id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i",$u->id);  
        $stmt->execute();
        $result = $stmt->get_result(); 
        if($result){
        while($row = $result->fetch_array())  {
        $a = new Apply();
        $a->applyname = $row["applyname"];
        $a->flag = $row['flag'];
        $a->friendname = $row['friendname'];
        array_push($listObj,$a);
            }  //end while
        }  //end if
        $stmt->close();
        $mysqli->close();
        return $listObj;
    }//end selectApply
///////////////////////////////////////好友申请处理///////////////////////////////////////
    function dealApply($a){
        $mysqli = new mysqli("localhost","root","","mydb");
        $mysqli->set_charset('utf8');//设定字符集
        if ($a->flag) {  //为1表示同意申请，设置flag为1
        $sql = "update apply set flag=1 where applyname=? and friendname=?";
        }else{  //如果拒绝申请,删除记录
        $sql = "delete from apply where applyname=? and friendname=?";
        }
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss",$a->applyname,$a->friendname);  
        $result = $stmt->execute();
        return $result;
    }//end dealApply
}//end class
?>