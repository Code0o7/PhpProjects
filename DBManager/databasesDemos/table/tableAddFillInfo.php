<?php 
###################################
#添加表格填写信息
###################################


// 获取传过来的数据库名字
$db_name = $_GET["db_name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>选择表类型</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
</head>
<body>
    <form action="./tableAddCommit.php" method="POST">
        <h3>选择表的类型</h3>
        表名: <input type="text" name="tb_name" placeholder="请输入表名"/><br/><br/>
        <input type="radio" name="table_type" checked="checked"/ value="p">人员信息表
        <input type="radio" name="table_type" value="f"/>水果价格表
        <br />
        <input type="submit" value="确定" />
        <?php 
            echo "<input type='hidden' name='db_name' value=$db_name />";
        ?>
        
    </form>
</body>
</html>