<?php
// 获取传过来的数据库名字
$database_name = $_GET["name"];

// 连接数据库
$link = mysqli_connect("localhost","root","");
// sql语句
$sql = "drop database $database_name";
// 发送sql语句
$res = mysqli_query($link,$sql);
if($res){
    echo "数据库删除成功";
}else {
    echo "数据库删除失败";
}
// 返回数据库列表界面
header("refresh:1,url=../index.php")

?>