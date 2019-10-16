<?php
###################################
#删除一条数据
###################################

// 获取传过来的数据

// 数据库
$db_name = $_GET["db_name"];
// 表名
$tb_name = $_GET["tb_name"];
// 删除数据的条件
$condition = $_GET["condition"];

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// sql语句
$sql = "delete from {$tb_name} where $condition";

// 执行语句
$res = mysqli_query($link,$sql);

if($res){
    // 删除成功
    echo "删除成功";
}else {
    // 删除失败
    echo "删除失败";
}
header("refresh:2,url=../table/tableInfo.php?db_name={$db_name}&tb_name={$tb_name}");

?>