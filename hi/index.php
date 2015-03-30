<?php
$login = false;

session_start();

if(!empty($_SESSION['user']) && $_SESSION['user']=='admin')            //�ж��û��Ƿ��¼
   $login = true;
$file_array = array();
$folder_array = array();

$dir = 'contents';
$dh = opendir($dir);

if($dh)
{
    $filename = readdir($dh);

    while($filename)                                                   //ѭ���������¹鵵����־����
    {
        if($filename != '.' && $filename != '..')
        {
            //$folder_name = substr($filename,0,4).'-'.substr($filename,4,2);
            $folder_name = $filename;
            array_push($folder_array,$folder_name);
        }
        $filename = readdir($dh);
    }
}
rsort($folder_array);

$post_data = array();
foreach($folder_array as $folder)
{
    $dh = opendir($dir.'/'.$folder);                                   //����ÿ��Ŀ¼�µ���־�ļ�
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
            
            $temp_data['SUBJECT'] = $content_array[0];                  //���±���
            $temp_data['DATE'] = date('Y-m-d H:i:s',$content_array[1]); //����ʱ��
            $temp_data['CONTENT'] = $content_array[2];                  //��������
            $file = substr($file,0,9);                                  //��־���������ļ���
            $temp_data['FILENAME'] = $folder.'-'.$file;          
            array_push($post_data,$temp_data);
        }
    }
}
//print_r($post_data);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>���Բ�ѯϵͳ</title>
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
    <?php foreach($post_data as $post)
    {
    ?>
        <div id="blog_entry">
        <div id="blog_title"><? echo $post['SUBJECT']; ?></div>
            <div id="blog_body">
                <div id="blog_date"><?php echo $post['DATE']; ?></div>
                <?php echo $post['CONTENT'];?>
                <div>
                    <?php
                        if($login)
                        {
                            echo '<a href="edit.php?entry='.$post['FILENAME'].'">�༭</a> &nbsp; <a href="delete.php?entry='.$post['FILENAME'].'">ɾ��</a>';    
                        }
                     ?>
                </div>
            </div><!--blog_body-->
        </div><!--blog_entry-->
    <?php } ?>
    </div>
    
    <div id="right">
        <div id="sidebar">
            <div id="menu_title">������Ϣ</div>
            <div id="menu_body">
            ���� SA1422506
            <br/><br/>
            <?php if($login) {echo '<a href="logout.php">�˳�<br/><br/></a>';echo '<a href="add.php">��ӿ���</a>'; } else{ echo '<a href="login.php">��¼</a>';} ?>
            <br/><br/>
           
            </div>
        </div>
        <br/>
        <div id="sidebar">
            <div id="menu_title">���Թ鵵</div>
            <?php foreach($folder_array as $ym)
            {
                $entry = $ym;
                $ym = substr($ym,0,4).'-'.substr($ym,4,2);
                echo '<div id="menu_body"><a href="archives.php?ym='.$entry.'">'.$ym.'</a></div>';
            }
            ?>
        </div>
    </div>
    
    <div id="footer">�пƴ� ���������о�����</div>
</div>

<body>
</html>
<?php closedir($dh);?>