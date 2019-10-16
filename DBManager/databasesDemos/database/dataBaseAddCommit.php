<?php

// 获取用户填写的数据库名
$name = isset($_POST["name"]) ? $_POST["name"] : "";
if($name==""){
    header("refresh:1,url=./addDataBase.php");
    die("数据库名不能为空");
}

$charset = $_POST["charset"];
$collation = $_POST["collation"];

// 获取flag值
$flag = $_POST["flag"];

// 添加数据库

// 连接数据库
$link = mysqli_connect("localhost","root","");

// sql语句
$sql = null;
if($flag == 1){
    // 修改数据库
    $sql = "alter database $name charset=$charset collate=$collation";
}else{
    // 创建数据库
    $sql = "create database $name charset=$charset collate=$collation";
}


// 发送sql语句
$res = mysqli_query($link,$sql);

// 判断执行结果
if($res) {
    echo $flag == 1 ? "数据库修改成功" : "数据库创建成功";
    header("refresh:1,url=../index.php");
}else {
    echo $flag == 1 ? "数据库修改失败" : "数据库创建失败";
    header("refresh:1,url=./dataBaseAddFillInfo.html?flag={$flag}&name={$name}");
}
?>

