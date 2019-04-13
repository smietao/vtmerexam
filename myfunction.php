<?php
class MyFunction{
//////////////////////////字符转换，向数据库中插入或更新时用/////////////////////////////
	function str_to($str)
	{
	  $str=str_replace(" ","&nbsp;",$str);  //把空格替换html的字符串空格
    $str=str_replace(" ","&nbsp;",$str);  //把空格替换html的字符串空格
	  $str=str_replace("<","&lt;",$str);    //把html的输出标志正常输出
	  $str=str_replace(">","&gt;",$str);    //把html的输出标志正常输出
	  $str=nl2br($str);                     //把回车替换成html中的br
	  return $str;
	}
  //end str_to
  function showMicroblog($m_list,$limit){   //显示微博的函数
    foreach ($m_list as $m) {//循环输出微博   
 ?>
    <table width="700px" border="1" cellpadding="12" cellspacing="0" align="center">
 <tr>
 <td colspan="2" class="bg"><?php echo '用户:<em>'.$m->author.'</em>'; ?>
 </td>
 </tr>
 <tr>
 <td rowspan="1" class="left">
 <span class="centre"><?php echo $m->subject; ?></span>
 </td>
 <td>
<?php echo $m->content ;?>
 </td>
 </tr>

 <tr>
 <td colspan='2'>发布时间：<?php echo $m->last_post_time;?>
 <span 
 class="spa"><a style="color: blue" href="reply.php?id=<?php echo $m->id?>">[评论]</a>
</span>
 <span class="fh">
  <a style="color: brown" href="like.php?id1=<?php echo $m->id?>">[点赞]</a>
 </span>
 <?php 
  if ($limit) { ?>
   <span class="fh">
  <a style="color: red" href="delete.php?id2=<?php echo $m->id; ?>"
      onclick="return confirm('确定将此微博删除?删除后无法恢复')">[删除]</a>
 </span>
 <?php }//if右括号
 ?>
 </td>
 </tr>

 <?php
 if($m->comment_count==0){
 echo "<tr>
 <td colspan='2'>评论：暂时还没有评论哦o((>ω< ))o</td>
 </tr>";
 }else{  ?>
 <tr>
  <td style="color: blue" colspan='2'>评论数量:<?php echo $m->comment_count ?> 
   <span class="spa">
     <a style="color: blue" href="comment.php?id=<?php echo $m->id?>">[评论详情]</a>
   </span>
  </td>
 </tr>
 <?php
 } //else的右括号
 ?>

 <tr>
 <td colspan='2'> 
  <?php 
     if($m->likes){
      echo '<span style="color: brown"><img src="zan.jpg" width="16" height="16">'."点赞数:".$m->likes.'</span>'; ?>
      <span class="spa">
      <a style="color: brown" href="showlike.php?id=<?php echo $m->id?>">[点赞列表]</a>
      </span>
  <?php
                       }//if的右括号
     else{
      echo "点赞：这条微博暂时还没有用户点赞过喔( •̀ ω •́ )✧";
     }
      ?>
 </td>
 </tr>
</table>

<?php
    }//foreach语句的右括号
  }//end showMicroblog
///////////////////////////////////显示用户个人信息//////////////////////////////////////
  function showUser($row,$limit){  
    ?>
    <table width="550px" border="1" cellpadding="12" cellspacing="1" align="center">
  <caption>个人资料</caption>
   <tr>
  <td colspan="4" class="title"><?php echo $row['username'] ?>
  <?php if($limit){  //如果$limit不为0，显示编辑资料，用于区分个人中心和搜索用户  ?>
   <span class="spa">
    [<a style="color: white" href="edit.php">编辑资料]</a>
   </span>
   <span class="spa">
    [<a style="color: white" href="login.html">注销登录]</a>
   </span>
   <span class="spa">
    [<a style="color: white" href="change.html">修改密码]</a>
   </span>
  <?php }  ?>
   <span class="spa">
    [<a style="color: white" href="index.php">返回首页]</a>
   </span>
    </td>
   </tr>
   <tr>
    <td align="center" width="20%">账 号</td>
    <td align="center" width="30%"><?php echo $row['account']; ?></td>
    <td align="center" width="20%">性 别</td>
    <td align="center" width="30%"><?php echo $row['gender'] ?></td>
   </tr>
   <tr>
    <td align="center">等 级</td>
    <td align="center"><?php echo "V".$row['grade'] ?></td>
    <td align="center">经验值</td>
    <td align="center"><?php 
      if ($row['experience']<100) {
        echo $row['experience']."/100";
      }else if ($row['experience']<300) {
        echo $row['experience']."/300";
      }else if ($row['experience']<1000) {
        echo $row['experience']."/1000";
      }else if ($row['experience']<2000) {
        echo $row['experience']."/2000";
      }else if($row['experience']<5000) {
        echo $row['experience']."/5000";
      }  ?>
     </td>
   </tr>
   <tr>
    <td align="center">生 日</td>
    <td align="center"><?php echo $row['birthday'] ?></td>
    <td align="center">星 座</td>
    <td align="center"><?php echo $row['constellation'] ?></td>
   </tr>
   <tr>
    <td align="center" colspan="1">邮 箱</td>
    <td colspan="3"><?php echo $row['email'] ?></td>
   </tr>
   <tr>
    <td align="center" colspan="1">兴趣爱好</td>
    <td colspan="3"><?php echo $row['hobby'] ?></td>
   </tr>
   <tr>
    <td align="center" colspan="1">个性签名</td>
    <td colspan="3"><?php echo $row['signature'] ?></td>
   </tr>
  </table>
  <?php }  //end showUser
}//end class
?>