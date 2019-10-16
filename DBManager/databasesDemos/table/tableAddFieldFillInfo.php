<?php
###################################
#给表添加字段 输入字段信息
###################################

// 获取数据库名和表名
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];

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
    <h2><?php echo "给{$db_name}中的{$tb_name}表添加字段"?></h2>
    <form action="tableAlterFieldCommit.php" method="post">
        <table cellspacing="1" cellpadding="5">
            <tr>
                <td>字段名:</td>
                <td><input type="text" name="f_name" placeholder="请输入要添加的字段名"></td>
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
                <td><textarea name="f_comment"></textarea></td>
            </tr>
        </table>
        <input id="db_name" type="hidden" name="db_name" />
        <input id="tb_name" type="hidden" name="tb_name" />
        <input type="hidden" name="type" value="1">
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