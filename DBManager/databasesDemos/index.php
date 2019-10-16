<?php
// 查询本地数据库

// 连接数据库
$link = mysqli_connect("localhost","root",'');

// 查询数据库语句
$sql = "show databases;";

// 发送sql语句
$res = mysqli_query($link,$sql);

// 解析结果
$rows = array();
while($row = mysqli_fetch_assoc($res)){
    $rows[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link  rel="stylesheet" type="text/css" href='myStyles.css'/>
    <title>数据库操作</title>
</head>
<body>
    <table class="tb-list" cellspacing="1" cellpadding="8">
        <caption align="center">数据库列表</caption>
        <tr>
            <th>数据库名</th>
            <th>数据库操作</th>
            <th>表操作</th>
        </tr>
        <?php foreach($rows as $value){?>
        <tr>
            <td><?php echo "{$value['Database']}" ?></td>
            <td>
                <a href=<?php echo "./database/dataBaseAddFillInfo.php?name=".$value["Database"]."&flag=1"?>>
                    修改
                </a>
                <a href=<?php echo "./database/dataBaseDelete.php?name=".$value["Database"]?>>
                    删除
                </a>
            </td>
            <td>
                <a href=<?php echo './table/tableLists.php?db_name='.$value["Database"]; ?>>查看表</a>
            </td>
        </tr>
        <?php }?>
        <tr align="center">
            <td colspan="3">
                <a href="./database/dataBaseAddFillInfo.php?flag=2">新增数据库</a>
            </td>
        </tr>
    </table>
</body>
</html>