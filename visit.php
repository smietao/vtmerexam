<!DOCTYPE html>
<html>
<head>
  <title>个人中心</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
include "../mysql/visitorService.php";  
session_start();
$v = new Visitor();
$v->be_id = $_SESSION['id'];  //当前用户id，也是访客表的be_id
?>
<table width="45%" border="1" cellpadding="12" cellspacing="0" align="left">
      <caption><h2 style="color:red ">访客中心</h2></caption>
      <tr class="bg">
       <th>访客</th>
       <th>访问时间</th>
      </tr>
<?php
$vs = new VisitorService();
$v_list = $vs->showVisit($v);  //显示访客信息
foreach ($v_list as $v1) 
  {  ?>
    <tr>
      <td rowspan="1" class="left">
        <?php echo $v1->visitorname; ?>
      </td>
      <td>
        <?php echo $v1->time; ?>
      </td>
    </tr>
<?php
   }//foreach语句的右括号
?>
</table>
<a href="javascript:history.back(-1)">返回上一页</a>
</body>
</html>
