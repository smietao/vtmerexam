<?php
include "microblog.php";
class MicroblogService{
///////////////////////////////////查询所有微博////////////////////////////////////////
	function microblogList(){
		$listObj =array();
		$conn = mysqli_connect("localhost","root","","mydb");
		if(mysqli_connect_errno($conn)){
			echo "连接数据库失败！！";
			exit;
		}
		$sql = "select * from microblog order by id desc";
		$result = mysqli_query($conn,$sql);
		if($result){
			while($row=mysqli_fetch_array($result))  {
				$m = new Microblog();
				$m->id = $row["id"];
				$m->subject = $row["subject"];
				$m->content = $row["content"];
				$m->author = $row["author"];
				$m->last_post_time = $row["last_post_time"];
				$m->comment_count = $row["comment_count"];
				$m->likes = $row["likes"];
				array_push($listObj,$m);
			}
		}
		mysqli_free_result($result);
        mysqli_close($conn);
		return $listObj;
	} //end microblogList
///////////////////////////////////添加微博功能/////////////////////////////////////////
	function addMicroblog($m){
		$result = 0;
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		if (strlen($m->content)<=600) {  //判断微博正文长度
		$sql = "insert into microblog (subject,content,author,last_post_time) values (?,?,?,?)";
		$insert = $mysqli->prepare($sql);	
		$insert->bind_param("ssss",$m->subject,$m->content,$m->author,$m->last_post_time);
		//对应字段参数先后顺序加入参数值
		$res=$insert->execute();
		if($res){  
			$result = 1;  //发布成功返回1

		}else{
			$result = 2;  //发布失败返回2
		}
	    }else{
	    	$result = 0; //如果微博正文长度超过200字，返回0
	    }
		return $result;
		$insert->close();
		$mysqli->close();
	}  //end addMicroblog
//////////////////////根据用户名查询微博，用于个人中心和搜索用户显示微博////////////////////
	function userMicroblog($u,$page){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select * from microblog where author=? order by id desc 
		      limit 3 offset $page";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s",$u->username);
		$stmt->execute();  //居然忘了写执行...
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$m = new Microblog();
				$m->id = $row["id"];
				$m->subject = $row["subject"];
				$m->content = $row["content"];
				$m->author = $row["author"];
				$m->last_post_time = $row["last_post_time"];
				$m->comment_count = $row["comment_count"];
				$m->likes = $row["likes"];
				array_push($listObj,$m);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}  //end userMicroblog
///////////////////////////////////根据微博id删除微博////////////////////////////////////
    function deleteMicroblog($m){
    	$mysqli = new mysqli("localhost","root","","mydb");
    	$mysqli->set_charset('utf8');//设定字符集
    	$sql="delete from love where microblog_id=?";  //删除相关点赞数据
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("i",$m->id); 
    	$res=$stmt->execute();
    	$sql="delete from comment where microblog_id=?"; //删除相关评论数据
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("i",$m->id); 
    	$res=$stmt->execute();
    	$sql="delete from microblog where id=?";  //删除微博
    	$stmt = $mysqli->prepare($sql);
    	$stmt->bind_param("i",$m->id); 
    	$res=$stmt->execute();
    	if($res){
    	    $result=1;
        }else{
        	$result=0;
        }
        return $result;
        $stmt->close();
        $mysqli->close();
    }//end deleteMicroblog
//////////////根据微博id查询微博,用于评论详情和点赞列表显示单条微博////////////////////////
    function idMicroblog($m){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select * from microblog where id=? order by id desc";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i",$m->id);
		$stmt->execute(); 
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$m = new Microblog();
				$m->id = $row["id"];
				$m->subject = $row["subject"];
				$m->content = $row["content"];
				$m->author = $row["author"];
				$m->last_post_time = $row["last_post_time"];
				$m->comment_count = $row["comment_count"];
				$m->likes = $row["likes"];
				array_push($listObj,$m);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}  //end idMicroblog
//////////////////////////////////根据主题查询微博///////////////////////////////////////
	function subjectMicroblog($m){
		$listObj = array();
		$mysqli = new mysqli("localhost","root","","mydb");
		$mysqli->set_charset('utf8');//设定字符集
		$sql="select * from microblog where subject=? order by id desc";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s",$m->subject);
		$stmt->execute(); 
		$result = $stmt->get_result(); 
		if($result){
			while($row = $result->fetch_array())  {
				$m1 = new Microblog();
				$m1->id = $row["id"];
				$m1->subject = $row["subject"];
				$m1->content = $row["content"];
				$m1->author = $row["author"];
				$m1->last_post_time = $row["last_post_time"];
				$m1->comment_count = $row["comment_count"];
				$m1->likes = $row["likes"];
				array_push($listObj,$m1);
			}  //end while
		}  //end if
		$stmt->close();
		$mysqli->close();
		return $listObj;
	}//end subjectMicroblog
//////////////////////////////根据用户名查找微博数量/////////////////////////////////////
	function countMicroblog($u){
		$mysqli = new mysqli("localhost","root","","mydb");
        $mysqli->set_charset('utf8');//设定字符集
        $sql="select count(*) from microblog where author=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s",$u->username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
        $stmt->close();
        $mysqli->close();
	}//end countMicroblog
////////////////////////////////////分页函数//////////////////////////////////////////
	function showPage($page,$count){  //$page为当前页数,$u为用户对象
		if ($count%3) {  //计算总页数
           $allpage=(int)($count/3)+1;
        }else{
           $allpage=$count/3;
        }
        if ($page!=1) { //如果当前页数不为一，显示上一页 ?> 
            <p align="center">
            	<a href="search1.php?page=<?php echo $page-1; ?>">上一页</a>
            </p>
        <?php }
        echo "<p align='center'>第".$page."页/第".$allpage."页</p>";
        if($page!=$allpage){ //如果当前页数不等于总页数显示下一页 ?> 
            <p align="center">
            	<a href="search1.php?page=<?php echo $page+1; ?>">下一页</a>
            </p>
        <?php }
        echo '<h4 align="center"><a href="index.php">返回首页</a></h4>';  

	}//end showPage
 } //end class
?>