<?php
include 'config/auth.php';
session_start();

if(isset($_POST['user']) && isset($_POST['passwd']))
{
    $user = $_POST['user'];
    $passwd = $_POST['passwd'];
    
    $passwd = md5($passwd);
    
    if($user != $AUTH['user'] || $passwd != $AUTH['passwd'])    //验证失败
    {
        echo '<strong><font color="red">用户名或密码错误！</font></strong>';
    }
    else
    {
        $_SESSION['user'] = $user;                              //验证成功，设置session
        header("location: index.php");
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>用户登录</TITLE><LINK 
href="images/Default.css" type=text/css rel=stylesheet><LINK 
href="images/xtree.css" type=text/css rel=stylesheet><LINK 
href="images/User_Login.css" type=text/css rel=stylesheet>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.6000.16674" name=GENERATOR></HEAD>
<BODY id=userlogin_body>
<DIV>
<p align="center" style="text-align:center;">
<img src="images/xiaohui.jpg" width="544" height="129" align="middle"></DIV>

<DIV id=user_login >
<DL>
  <DD id=user_top>
  <UL>
    <LI class=user_top_l ></LI>
    <LI class=user_top_c></LI>
    <LI class=user_top_r></LI></UL>
  <DD id=user_main>
  <UL>
    <LI class=user_main_l></LI>
    <LI class=user_main_c>
    <DIV class=user_main_box>
	<form method="POST" action="login.php">
    <UL>
      <LI>用户名： </LI>
      <LI><input type="text" name="user" size="15"> </LI></UL>
    <UL>
      <LI>密 码：</LI>
      <LI><input type="password" name="passwd" size="15"> </LI></UL>
    <UL>
      </UL></DIV></LI>
	   
    <LI class=user_main_r>
   <input value="" style="background:url(images/user_botton.gif) no-repeat;border:none;width:100px; height:150px;" type="submit" >
       </LI></UL></form>
  <DD id=user_bottom>
  <UL>
    <LI class=user_bottom_l></LI>
    <LI class=user_bottom_c><SPAN style="MARGIN-TOP: 40px"></SPAN> </LI>
    <LI class=user_bottom_r></LI></UL></DD></DL>
</DIV><SPAN id=ValrUserName 
style="DISPLAY: none; COLOR: red"></SPAN><SPAN id=ValrPassword 
style="DISPLAY: none; COLOR: red"></SPAN><SPAN id=ValrValidateCode 
style="DISPLAY: none; COLOR: red"></SPAN>
<DIV id=ValidationSummary1 style="DISPLAY: none; COLOR: red"></DIV>

<DIV></DIV>

</FORM></BODY></HTML>
