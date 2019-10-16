<?php
###################################
#选择字段 下一步修改或删除字段
###################################

// 获取传过来的信息
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];

// 操作类型 2:修改字段 3:删除字段
$type = $_GET["type"];
$tip_message = null;
$jump_page = "tableAlterFieldCommit.php";
if($type == 2){
    $tip_message = "选择要修改的字段";
    $jump_page = "tableChangeField.php";
}else {
    $tip_message = "选择要删除的字段";
}

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// 获取表字段信息sql语句
$sql = "desc $tb_name";

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
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
    <style type="text/css">
        .field{
            font-size: 18px;
            font-weight: bold;
        }
        .type{
            color:#ccc;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2><?php echo "{$tip_message}";?></h2>
    <form action=<?php echo "$jump_page"?> method="post">
        <?php foreach($rows as $value): $v=$value['Field'];?>
            <input type="radio" name="f_name" value=<?php echo "{$v},{$value['Type']}";?>>&nbsp;
            <?php echo "<span class='field'>{$value['Field']}"?>
            <?php echo "<span class='type'>{$value['Type']}</span>"?>
            <br>
        <?php endforeach;?>
        <input type="submit" value="确定"/>
        <input id="db_name" type="hidden" name="db_name" />
        <input id="tb_name" type="hidden" name="tb_name" />
        <input id="type" type="hidden" name="type" />
    </form>
</body>
</html>
<script>
    window.onload = function(){
        var db_name = '<?php echo $db_name;?>';
        var tb_name = '<?php echo $tb_name;?>'; 

        var type = '<?php echo $type;?>';

        document.getElementById("db_name").setAttribute("value",db_name);
        document.getElementById("tb_name").setAttribute("value",tb_name);
        document.getElementById("type").setAttribute("value",type);
    }
</script>