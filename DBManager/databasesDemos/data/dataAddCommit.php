<?php
###################################
#添加数据 提交信息
###################################

// 获取传过来的数据

// 数据库名
$db_name = $_POST["db_name"];
$tb_name = $_POST["tb_name"];

// 获取其他参数
$post = $_POST;
unset($post["db_name"]);
unset($post["tb_name"]);

$keys = array();
$values_str = "";

$faile = false;

$count = count($post);
$index = 0;

foreach($post as $key=>$value){
    $index++;

    if(!isset($value)) {
        $faile = true;
        break;
    }
    $keys[] = $key;

    if($index == $count){
        $values_str.="'{$value}'";
    }else {
        $values_str.="'{$value}',";
    }
}

// 处理数据
$keys_str = implode(",",$keys);

// 字段未填写完整
if($faile){
    header("refresh:2,url=dataAddFillInfo.php?db_name=$db_name&tb_name=$tb_name");
    die("字段未填写完整");
}

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// 设置通信编码
mysqli_query($link,"set names utf8");

// sql语句
$sql = "insert into $tb_name ({$keys_str}) values($values_str)";

// 执行
$res = mysqli_query($link,$sql);

if($res){
    echo "添加数据成功";
}else {
    echo "添加数据失败";
}

header("refresh:2,url=../table/tableInfo.php?db_name=$db_name&tb_name=$tb_name");

?>