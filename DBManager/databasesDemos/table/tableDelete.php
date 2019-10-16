<?php
###################################
#删除表
###################################

// 获取传过来的数据 数据库名和表名
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];


// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// sql语句
$sql = "drop table $tb_name";

// 发送sql语句
$res = mysqli_query($link,$sql);

if($res){
    echo "{$tb_name}表删除成功";
}else {
    echo "删除{$tb_name}表失败";
}
header("refresh:2,url=tableLists.php?db_name=$db_name");

?>