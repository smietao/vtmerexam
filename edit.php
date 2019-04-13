<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>编辑资料</title>
 <link rel="stylesheet" type="text/css" href="add.css">
</head>
<?php
include '../mysql/userService.php';
session_start();
$u = new User();
$u->username = $_SESSION['username'];
$us = new UserService();
$row=$us->userInfo($u); //查询用户信息，返回数组$row
?>
<body>
  <form action="save_edit.php" method="post">
    <table width="500px" cellspacing="0" cellpadding="8" align="center">
      <tr id="title">
        <td colspan="2" style="background-color: #B10707">编辑资料
          <span class="right">
      	[<a style="color: white" href="users.php">个人中心</a>]
          </span>
        </td>
      </tr>
      <tr>
        <td align="center" width="150px">用户名(10字以内)</td>
        <td>
           <input value="<?php echo $row['username']?>" class="input" type="text" name="username" autocomplete="off">
        </td>
      </tr>
      <tr>
        <td align="center">性 别：</td>
        <td>
            <select name="gender" class="input">
                  <option value="GG">GG</option>
                  <option value="MM">MM</option>
            </select>
        </td>
      </tr>
      <tr>
        <td align="center">生 日：</td>
        <td>
            <input value="<?php echo $row['birthday']?>" type="date" name="birthday">
        </td>	
      </tr>
      <tr>		
        <td align="center">星 座：</td>
        <td>
            <select name="constellation" class="input">
                  <option value="白羊座">白羊座</option>
      		<option value="金牛座">金牛座</option>
      		<option value="双子座">双子座</option>
      		<option value="巨蟹座">巨蟹座</option>
      		<option value="狮子座">狮子座</option>
      		<option value="处女座">处女座</option>
      		<option value="天枰座">天枰座</option>
      		<option value="天蝎座">天蝎座</option>
      		<option value="射手座">射手座</option>
      		<option value="魔蝎座">魔蝎座</option>
      		<option value="水瓶座">水瓶座</option>
      		<option value="双鱼座">双鱼座</option>
      	</select>
        </td>
      </tr>
      <tr>
        <td align="center">兴趣爱好<br>(50字以内)：</td>		
        <td>            
            <textarea name="hobby" cols="35" rows="6"></textarea>
        </td>	
      </tr>
      <tr>
        <td align="center">个性签名<br>(100字以内)：</td>
        <td><textarea name="signature" cols="35" rows="8"></textarea></td>	
      </tr>
      <tr>
        <td colspan="2" align="center">
            <button class="btn" style="text-align: center">提交修改</button>
        </td>
      </tr>
  </table>
</form>
</body>
</html>