<?php
session_start();
$ok = false;

if(!isset($_GET['entry']))
{
    echo '请求参数错误！';
    exit;
}

if(empty($_SESSION['user']) || $_SESSION['user']!='admin')
{
    echo '请<a href="login.php">登录</a>后执行该操作。';
    exit;
}

$path = substr($_GET['entry'],0,6);             //日志存储目录
$entry = substr($_GET['entry'],7,9);            //日志文件名称
$file_name = 'contents/'.$path.'/'.$entry.'.txt';

if(file_exists($file_name))                     //取出原文件内容
{
    $fp = @fopen($file_name, 'r');
    if($fp)
    {
        flock($fp, LOCK_SH);
        $result = fread($fp, filesize($file_name));
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    
    $content_array = explode('|', $result);      //将文件内容存放在数组中
}

if(isset($_POST['title']) && isset($_POST['content']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if(file_exists($file_name))
    {
        //根据用户修改时提交的内容，替换现有文件的内容，注意替换的对应关系，即标题、内容各自对应做替换
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
        $msg = '日志修改成功，<a href="post.php?entry='.$_GET['entry'].'">查看该日志文章</a>';
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>基于文本的简易BLOG</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<div id="container">
    <div id="header">
        <h1>编辑考试</h1>
    </div>
    <div id="title">
        ----cmet考试查询
    </div>

    <div id="left">
        <div id="blog_entry">
            <div id="blog_title">编辑考试</div>
            
            <div id="blog_body">
            <?php if($ok == false) 
            {
            ?>
                <div id="blog_date"></div>
                <table border="0">
                <form method="POST" action="edit.php?entry=<?php echo $_GET['entry'];?>">
                    <tr><td>考试标题：</td></tr>
                    <tr><td><input type="text" name="title" size="50" value="<?php echo $content_array[0]; ?>"></td></tr>
                    <tr><td>考试信息：</td></tr>
                    <tr><td><textarea name="content" cols="49" rows="10"><?php echo $content_array[2];?></textarea></td></tr>
                    <tr><td>创建于：<?php echo date('Y-m-d H:i:s',$content_array[1]); ?></td></tr>
                    <tr><td><input type="submit" value="提交"></td></tr>
                </form>
                </table>
            <?php } ?>
            <?php if ($ok == true){ echo $msg; }?>
            </div><!-- blog_body-->
        </div><!-- blog_entry-->
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">考生信息</div>
            <div id="menu_body">王鑫 学号SA14225006</div>
        </div>
    </div>
    
    <div id="footer">
        中科大 教育技术研究中心
    </div>
</div>

<body>
</html>