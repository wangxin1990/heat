<?php
session_start();
$info = '';

if(isset($_SESSION['user']))
{
    $_SESSION['user'] = '';
    $msg = '���Ѿ��ɹ��˳���<a href="index.php">������ҳ</a>';
}
else
{
    $msg = '��δ����¼���Ѿ���ʱ�˳���<a href="index.php">������ҳ</a>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>�����ı��ļ���BLOG</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<div id="container">
    <div id="header">
        <h1>���Բ�ѯϵͳ</h1>
    </div>
    <div id="title">
        cmet����ϵͳ
    </div>
    <div id="left">
        <div id="blog_entry">
            <div id="blog_title">�˳���¼</div>
            <div id="blog_body">
            <?php echo $msg; ?>
            </div><!--blog_body-->
        </div><!--blog_entry-->
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">������</div>
            <div id="menu_body">���� SA1422506</div>
        </div>
    </div>
    
    <div id="footer">
        �пƴ� ���������о�����
    </div>
</div>

<body>
</html>