<?php
if(!isset($_GET['entry']))
{
    echo '请求参数错误';
    exit;
}

$post_data = array();

$path = substr($_GET['entry'],0,6);             //日志存储目录
$entry = substr($_GET['entry'],7,9);            //日志文件名称

$file_name = 'contents/'.$path.'/'.$entry.'.txt';

if(file_exists($file_name))
{
    $fp = @fopen($file_name, 'r');
    if($fp)
    {
        flock($fp, LOCK_SH);
        
        $result = fread($fp, filesize($file_name)*100);
    }
    flock($fp, LOCK_UN);
    fclose($fp);
}

$content_array = explode('|', $result);

$post_data['SUBJECT'] = $content_array[0];
$post_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]);
$post_data['CONTENT'] = $content_array[2];
//print_r($post_data);
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
		<h1>我的BLOG</h1>
	</div>
	<div id="title">
		----i have dream....
	</div>
	<div id="left">
		<div id="blog_entry">
			<div id="blog_title"><?php echo $post_data['SUBJECT'];?></div>
			<div id="blog_body">
				<div id="blog_date"><?php echo $post_data['DATE'];?></div>
				<?php echo $post_data['CONTENT'];?>
			</div><!--blog_body-->
		</div><!--blog_entry-->

	</div>
	
	<div id="right">
        <div id="sidebar">
            <div id="menu_title">关于我</div>
            <div id="menu_body">我是个PHP爱好者</div>
        </div>
    </div>
	
	<div id="footer">
		CopyRight 2011
	</div>
</div>

<body>
</html>