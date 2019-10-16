<?php
###################################
#查看数据库内所有的表信息
###################################

// 获取数据库名字
$db_name = $_GET["db_name"];

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// sql语句
$sql = "show tables";

// 发送sql语句
$res = mysqli_query($link, $sql);

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
    <title>查看表</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
</head>
<body>
    <table class="tb-list" cellspacing="1" cellpadding="8">
        <caption align="center">数据表信息</caption>
        <tr>
            <th>数据库名</th>
            <th>表名</th>
            <th>操作</th>
        </tr>
        <?php foreach($rows as $key=>$value):?>
            <tr>
                <?php
                 $count = count($rows) + 1;
                 if($key==0) echo "<td rowspan=$count>$db_name</td>"; else echo null;
                 ?>
                <td><?php echo $value["Tables_in_{$db_name}"]?></td>
                <td>
                    <a href=
                    <?php
                        $tb_name = $value["Tables_in_{$db_name}"];
                        echo "tableInfo.php?tb_name=$tb_name"."&db_name=$db_name"
                    ?>
                    >查看</a>
                    <select id="select" class=<?php echo "$tb_name";?>>
                        <option>修改</option>
                        <option>添加字段</option>
                        <option>修改字段</option>
                        <option>删除字段</option>
                    </select>
                    <a href=
                        <?php echo "tableDelete.php?tb_name=".$value["Tables_in_{$db_name}"]."&db_name=$db_name"?>
                    >删除</a>
                </td>
            </tr>
        <?php endforeach;?>
        <tr>
            <?php 
                if(count($rows) == 0){
                    echo "<td>{$db_name}</td>";
                }else {
                    echo null;
                }
            ?>
            <td colspan="2" align="center">
                <a href=<?php echo "tableAddFillInfo.php?db_name=$db_name"; ?>>新增表</a>
            </td>
        </tr>
    </table>
</body>
</html>
<script>
    window.onload = function(){
        // 获取select控件
        var select = document.getElementById("select");

        // 数据库名和表名
        var db_name = '<?php echo "$db_name";?>';
        var tb_name = select.className;

        // 监听事件
        select.onchange = function(){
            
            // 获取选择了哪一个
            if(this.selectedIndex == 1){

                // 添加字段
                window.location.href = "./tableAddFieldFillInfo.php?db_name="+db_name+"&tb_name="+tb_name;
            }else if(this.selectedIndex == 2){
                // 修改字段
                window.location.href = "./tableChooseField.php?db_name="+db_name+"&tb_name="+tb_name+"&type=2";
            }else if(this.selectedIndex == 3){
                // 删除字段
                window.location.href = "./tableChooseField.php?db_name="+db_name+"&tb_name="+tb_name+"&type=3";
            }
            
        }
    }

</script>