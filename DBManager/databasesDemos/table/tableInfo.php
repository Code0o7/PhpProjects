<?php
###################################
#显示表的数据信息
###################################


// 获取数据库信息和表信息
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];

// 连接数据库
$link = mysqli_connect("localhost","root",'',$db_name);

// 设置通信编码
mysqli_query($link,"set name utf8");

// 查询表结构sql语句
// $sql1 = "desc $tb_name";
$sql1 = "show full columns from $tb_name";

// 发送sql
$res1 = mysqli_query($link,$sql1);
// 解析结果
$rows1 = array();
while($row = mysqli_fetch_assoc($res1)){
    $rows1[] = $row;
}


// 查询所有数据sql语句
$sql2 = "select * from $tb_name";

// 发送sql语句
// 设置通信编码
mysqli_query($link,"set names utf8");
$res2 = mysqli_query($link,$sql2);

// 解析结果
$rows2 = array();
while($row = mysqli_fetch_assoc($res2)){
    $rows2[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>数据信息</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
    <style type="text/css">
        span{
            color:#ccc;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <table class="tb-list" cellspacing="1" cellpadding="8">
        <caption align="center">
            <?php echo "{$db_name}数据库中{$tb_name}表信息"?>
        </caption>
        <tr>
            <?php foreach($rows1 as $value):?>
            <th>
                <?php 
                    $fd = $value['Field'];
                    $tp = $value['Type'];
                    $co = $value['Comment'];
                    echo $fd; 
                    echo "<br/>";
                    echo "<span>{$tp}</span>";
                    echo "<br />";
                    echo "<span>{$co}</span>";

                ?>
            </th>
            <?php endforeach;?>
            <th>
                操作
            </th>
        </tr>
        <?php foreach($rows2 as $key=>$value):?>
        <tr>
            <?php foreach($value as $key1=>$data):?>
            <td><?php
                if($key1 == "sex"){
                    echo $data==0 ? "女" : "男";
                }else {
                    echo "$data";
                }
             ?></td>
            <?php endforeach;?>
            <td>
                <a href=<?php 
                        // 把查询出的数据传递到修改页面
                        $str = base64_encode(serialize($value));
                        echo "../data/dataUpdateFillInfo.php?db_name={$db_name}&tb_name={$tb_name}&data={$str}"
                    ?> >修改</a>
                <a href=
                    <?php 
                        $condition = null;
                        foreach($value as $k=>$v){
                            if(!empty($k) && !empty($v)){
                                $condition = "{$k}={$v}";
                                break;
                            }
                        }
                        echo "../data/dataDelete.php?db_name={$db_name}&tb_name={$tb_name}&condition={$condition}"
                    ?>
                >删除</a>
            </td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td colspan=<?php $c=count($rows1)+1; echo "$c"?> align="center">
                <a href=<?php echo "../data/dataAddFillInfo.php?db_name={$db_name}&tb_name={$tb_name}"?> >添加数据</a>
            </td>
        </tr>
    </table>
</body>
</html>