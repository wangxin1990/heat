<?php
session_start();
$ok = false;

if(empty($_SESSION['user']) || $_SESSION['user']!='admin')
{
    echo '��<a href="login.php">��¼</a>��ִ�иò�����';
    exit;
}

if(!isset($_GET['entry']))
{
    if(!isset($_POST['id']))
    {
        $ok = true;
        $msg = '�����������<a href="index.php">������ҳ</a>';
    }
    else
    {
        //��ɾ������
        $path = substr($_POST['id'],0,6);             //��־�洢Ŀ¼
        $entry = substr($_POST['id'],7,9);            //��־�ļ�����
        $file_name = 'contents/'.$path.'/'.$entry.'.txt';
        if(unlink($file_name))
        {
            $ok = true;
            $msg = '����־�ɹ�ɾ����<a href="index.php">������ҳ</a>';
        }
        else
        {
            $ok = true;
            $msg = '����־ɾ��ʧ�ܣ�<a href="index.php">������ҳ</a>';
        }
    }
}
else
{
    $form_data = '';
    $path = substr($_GET['entry'],0,6);             //��־�洢Ŀ¼
    $entry = substr($_GET['entry'],7,9);            //��־�ļ�����
    $file_name = 'contents/'.$path.'/'.$entry.'.txt';
    if(file_exists($file_name))
    {
        $form_data = '<input type="hidden" name="id" value="'.$_GET['entry'].'">';
    }
    else
    {
        $ok = true;
        $msg = '��Ҫɾ������־�����ڣ�<a href="index.php">������ҳ</a>';
    }
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
        <h1>�ҵ�BLOG</h1>
    </div>
    <div id="title">
        ----i have dream....
    </div>
    <div id="left">
        <div id="blog_entry">
            <div id="blog_title">ɾ����־</div>
            <div id="blog_body">
            <?php if($ok == false) 
            {
            ?>
                <form method="POST" action="delete.php">
                <font color="red">ɾ������־���޷��ָ���ȷ��Ҫɾ����</font><br/>
                <input type=submit value="ȷ��">
                <?php echo $form_data; ?>
                </form>
            <?php } ?>
            <?php if($ok == true) { echo $msg; } ?>
            </div><!--blog_body-->
        </div><!--blog_entry-->
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">������</div>
            <div id="menu_body">���Ǹ�PHP������</div>
        </div>
    </div>
    
    <div id="footer">
        copyright 2011
    </div>
</div>

<body>
</html>