<?php
###################################
#添加字段
###################################

// 获取数据库名和表名
$db_name = $_POST["db_name"];
$tb_name = $_POST["tb_name"];

// 要修改的字段名
$name_type = $_POST["f_name"];
$arr = explode(",",$name_type);

// 原来字段名
$f_name = $arr[0];

// 字段类型
$f_type = $arr[1];

// 查询注释

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// 设置通信编码
mysqli_query($link,"set name utf8");

// sql语句
$sql = "select column_comment from INFORMATION_SCHEMA.COLUMNS where table_name='{$tb_name}' and column_name='{$f_name}'";

//执行sql语句
$res = mysqli_query($link,$sql);


// 解析结果
$row = mysqli_fetch_assoc($res);

// 获取注释
$comment = $row["column_comment"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加字段</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
</head>
<body>
    <h2><?php echo "修改{$db_name}数据库中{$tb_name}表的{$f_name}字段"?></h2>
    <form action="tableAlterFieldCommit.php" method="post">
        <table cellspacing="1" cellpadding="5">
            <tr>
                <td>字段名:</td>
                <td><input type="text" name="f_name" placeholder="请输入要添加的字段名" value=<?php echo $f_name?>></td>
            </tr>
            <tr>
                <td>字段类型:</td>
                <td>
                    <select name="f_type">
                        <option>选择字段类型</option>
                        <option>tinyint</option>
                        <option>int</option>
                        <option>varchar(10)</option>
                        <option>varchar(20)</option>
                        <option>text</option>
                        <option>float</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>描述:</td>
                <td><textarea name="f_comment"><?php echo $comment?></textarea></td>
            </tr>
        </table>
        <input id="db_name" type="hidden" name="db_name" />
        <input id="tb_name" type="hidden" name="tb_name" />
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="origin_f_type" value=<?php echo $f_type?> />
        <input type="hidden" name="origin_f_name" value=<?php echo $f_name?>>
        <input type="submit" value="确定">
    </form>
</body>
</html>
<script>
    window.onload = function(){
        var db_name = '<?php echo $db_name;?>';
        var tb_name = '<?php echo $tb_name;?>'; 

        document.getElementById("db_name").setAttribute("value",db_name);
        document.getElementById("tb_name").setAttribute("value",tb_name);
    }
</script>