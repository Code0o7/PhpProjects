<?php
###################################
#添加表格提交信息
###################################

// 获取数据库名字
$db_name = $_POST["db_name"];

// 获取表名
$tb_name = isset($_POST["tb_name"]) ? $_POST["tb_name"] : '';
if(empty($tb_name)){
    header("refresh:2,url=./tableAddFillInfo.php?db_name=$db_name");
    die("表名不能为空");
}

// 获取表类型 p为人员信息表 f为水果价格表
$tb_type = $_POST["table_type"];


// 连接数据库
$link = mysqli_connect("localhost","root",'',$db_name);

// sql语句
$sql = null;
$tb_type_name = null;
if($tb_type == "p"){
    // 创建人员信息表
    $tb_type_name = "人员信息表";
    $sql = <<<EEE
        create table $tb_name (
            id tinyint not null auto_increment primary key comment 'id',
            name varchar(10) not null comment '姓名',
            sex varchar(2) not null comment '性别',
            age tinyint not null comment '年龄',
            zy varchar(20) not null comment '职业'
        )charset=utf8;
    EEE;
}else {
    // 创建水果价格表
    $tb_type_name = "水果价格表";
    $sql = <<<EEE
        create table $tb_name (
            id tinyint not null auto_increment primary key comment 'id',
            name varchar(10) not null comment '名字',
            price float not null comment '单价'
        )charset=utf8;
    EEE;
}

// 发送sql语句
$res = mysqli_query($link,$sql);
if($res){
    // 创建表成功
    echo "{$tb_type_name}创建成功";
    header("refresh:2,url=./tableLists.php?db_name=$db_name");
}else {
    // 创建失败
    echo "{$tb_type_name}创建失败";
    header("refresh:2,url=./tableAddFillInfo.php?db_name=$db_name");
}

?>