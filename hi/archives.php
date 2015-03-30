<?php
$ok = false;

if(!isset($_GET['ym']) || empty($_GET['ym']))
{
    $ok = true;
    $msg = '请求参数错误！<a href="index.php">返回首页</a>';
}

$folder_array = array();
$dir = 'contents';
$folder = $_GET['ym'];
if(!is_dir($dir.'/'.$folder))
{
    $ok = true;
    $msg = '请求参数错误！<a href="index.php">返回首页</a>';
}

$dh = opendir($dir);
if($dh)
{
    $filename = readdir($dh);
    while($filename)
    {
        if($filename != '.' && $filename != '..')
        {
            $folder_name = $filename;
            array_push($folder_array,$folder_name);
        }
        $filename = readdir($dh);
    }
}
rsort($folder_array);

$post_data = array();
$dh = opendir($dir.'/'.$folder);

while(($filename = readdir($dh)) !== FALSE)
{
    if(is_file($dir.'/'.$folder.'/'.$filename))
    {
        $file = $filename;
        $file_name = $dir.'/'.$folder.'/'.$file;
        
        if(file_exists($file_name))
        {
            $fp = @fopen($file_name, 'r');
            if($fp)
            {
                flock($fp, LOCK_SH);
                $result = fread($fp, filesize($file_name));
            }
            flock($fp, LOCK_UN);
            fclose($fp);
        }
        $temp_data = array();
        $content_array = explode('|', $result);
        
        $temp_data['SUBJECT'] = $content_array[0];
        $temp_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]);
        $temp_data['CONTENT'] = $content_array[2];
        array_push($post_data,$temp_data);
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
        <h1>考试查询系统</h1>
    </div>
    <div id="title">
        cmet考试查询
    </div>
    <div id="left">
    <?php 
    if($ok == false)
    {
        foreach($post_data as $post)
        {
    ?>
        <div id="blog_entry">
        <div id="blog_title"><? echo $post['SUBJECT']; ?></div>
            <div id="blog_body">
                <div id="blog_date"><? echo $post['DATE']; ?></div>
                <?php echo $post['CONTENT']; ?>
            </div><!--blog_body-->
        </div><!--blog_entry-->
    <?php } 
    }
    else{
    echo $msg;
    }
    ?>
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">关于我</div>
            <div id="menu_body">
            王鑫 SA14225006
            <br/><br/>
            <a href="login.php">登录</a>
            </div>
        </div>
        <br/>
        <div id="sidebar">
            <div id="menu_title">考试归档</div>
            <?php foreach($folder_array as $ym)
            {
                $entry = $ym;
                $ym = substr($ym,0,4).'-'.substr($ym,4,2);
                echo '<div id="menu_body"><a href="archives.php?ym='.$entry.'">'.$ym.'</a></div>';
            }
            ?>
        </div>
    </div>
    
    <div id="footer">
       中科大 教育技术研究中心
    </div>
</div>

<body>
</html>
