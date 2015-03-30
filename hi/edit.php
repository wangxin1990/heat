<?php
session_start();
$ok = false;

if(!isset($_GET['entry']))
{
    echo '�����������';
    exit;
}

if(empty($_SESSION['user']) || $_SESSION['user']!='admin')
{
    echo '��<a href="login.php">��¼</a>��ִ�иò�����';
    exit;
}

$path = substr($_GET['entry'],0,6);             //��־�洢Ŀ¼
$entry = substr($_GET['entry'],7,9);            //��־�ļ�����
$file_name = 'contents/'.$path.'/'.$entry.'.txt';

if(file_exists($file_name))                     //ȡ��ԭ�ļ�����
{
    $fp = @fopen($file_name, 'r');
    if($fp)
    {
        flock($fp, LOCK_SH);
        $result = fread($fp, filesize($file_name));
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    
    $content_array = explode('|', $result);      //���ļ����ݴ����������
}

if(isset($_POST['title']) && isset($_POST['content']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if(file_exists($file_name))
    {
        //�����û��޸�ʱ�ύ�����ݣ��滻�����ļ������ݣ�ע���滻�Ķ�Ӧ��ϵ�������⡢���ݸ��Զ�Ӧ���滻
           $blog_temp = str_replace($content_array[0],$title,$result);
        $blog_str = str_replace($content_array[2],$content,$blog_temp);
        
        $fp = @fopen($file_name, 'w');
        if($fp)
        {
            flock($fp, LOCK_EX);
            $result = fwrite($fp, $blog_str);
            $lock = flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    
    if(strlen($result)>0)
    {
        $ok = true;
        $msg = '��־�޸ĳɹ���<a href="post.php?entry='.$_GET['entry'].'">�鿴����־����</a>';
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
        <h1>�༭����</h1>
    </div>
    <div id="title">
        ----cmet���Բ�ѯ
    </div>

    <div id="left">
        <div id="blog_entry">
            <div id="blog_title">�༭����</div>
            
            <div id="blog_body">
            <?php if($ok == false) 
            {
            ?>
                <div id="blog_date"></div>
                <table border="0">
                <form method="POST" action="edit.php?entry=<?php echo $_GET['entry'];?>">
                    <tr><td>���Ա��⣺</td></tr>
                    <tr><td><input type="text" name="title" size="50" value="<?php echo $content_array[0]; ?>"></td></tr>
                    <tr><td>������Ϣ��</td></tr>
                    <tr><td><textarea name="content" cols="49" rows="10"><?php echo $content_array[2];?></textarea></td></tr>
                    <tr><td>�����ڣ�<?php echo date('Y-m-d H:i:s',$content_array[1]); ?></td></tr>
                    <tr><td><input type="submit" value="�ύ"></td></tr>
                </form>
                </table>
            <?php } ?>
            <?php if ($ok == true){ echo $msg; }?>
            </div><!-- blog_body-->
        </div><!-- blog_entry-->
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">������Ϣ</div>
            <div id="menu_body">���� ѧ��SA14225006</div>
        </div>
    </div>
    
    <div id="footer">
        �пƴ� ���������о�����
    </div>
</div>

<body>
</html>