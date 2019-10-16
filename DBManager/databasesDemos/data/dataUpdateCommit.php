<?php
###################################
#修改数据 提交信息
###################################

// 获取传过来的数据

// 数据库名
$db_name = $_POST["db_name"];
$tb_name = $_POST["tb_name"];

// 条件
$condition = $_POST["condition"];

// 获取其他参数
$post = $_POST;
unset($post["db_name"]);
unset($post["tb_name"]);
unset($post["condition"]);

$faile = false;

$count = count($post);
$index = 0;
$str = "";

foreach($post as $k=>$v){
    $index++;

    if($index == $count){
        // 最后一个
        $str = $str.$k."='{$v}'";
    }else {
        $str = $str.$k."='{$v}',";
    }
}

// 字段不能为空
if($faile){
    header("refresh:2,url=dataUpdateFillInfo.php?db_name=$db_name&tb_name=$tb_name");
    die("字段不能为空");
}

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// 设置通信编码
mysqli_query($link,"set names utf8");

// sql语句
$sql = "update {$tb_name} set {$str} where {$condition}";

// 执行
$res = mysqli_query($link,$sql);

if($res){
    echo "修改成功";
}else {
    echo "修改失败";
}

header("refresh:2,url=../table/tableInfo.php?db_name=$db_name&tb_name=$tb_name");
?>