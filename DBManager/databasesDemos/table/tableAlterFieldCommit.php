<?php
###################################
#添加/修改表字段信息
###################################

// 获取传过来的信息
// 数据库名
$db_name = $_POST["db_name"];
// 表名
$tb_name = $_POST["tb_name"];
// 操作类型 1:添加字段  3:删除字段
$type = $_POST["type"];

$f_name = null;
$f_type = null;
$f_comment = null;

// 原有的字段名
$origin_f_name = null;
// 原有的字段类型
$origin_f_type = null;
// 字段类型
$f_type = isset($_POST["f_type"]) ? $_POST["f_type"] : "";
// 字段名
$f_name = $_POST["f_name"];
// 字段描述
$f_comment = isset($_POST["f_comment"]) ? $_POST["f_comment"] : "";

if($type == 1){
    
}else if ($type == 2){
    // 修改字段
    $origin_f_type = $_POST["origin_f_type"];
    $origin_f_name = $_POST["origin_f_name"];
    $f_type == "选择字段类型" ? $f_type = $origin_f_type : $f_type;
}else if($type == 3){
    // 删除字段
    $f_name = $_POST["f_name"];
}

if($type != 3){
    // 字段名判断
    if(empty($f_name)){
        header("refresh:2,url=tableAddFieldFillInfo.php?db_name={$db_name}&tb_name={$tb_name}");
        die("字段名不能为空");
    }
}

if($type == 1){
    if($f_type == "选择字段类型"){
        header("refresh:2,url=tableAddFieldFillInfo.php?db_name={$db_name}&tb_name={$tb_name}");
        die("请选择字段类型");
    }
}

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);
// sql语句
$sql = null;
$message = null;
$res1 = true;
$res = false;
if($type == 1){
    // 添加字段
    $sql = "alter table $tb_name add $f_name $f_type not null comment '$f_comment';";
    $message = "添加字段";
}else if($type == 2){
    // 修改字段和字段类型

    // 修改字段
    if($f_name != $origin_f_name){
        $sql = "alter table $tb_name change $origin_f_name $f_name $origin_f_type not null comment '{$f_comment}'";
    }
    $res1 = mysqli_query($link,$sql);


    // 修改字段类型
    if($f_type != $origin_f_type){
        // 修改字段类型
        $sql = "alter table $tb_name modify $f_name $f_type not null comment '{$f_comment}'";   
    }else {
        $res = true;
    }
    
    $message = "修改字段";
}else if($type == 3){
    // 删除字段

    // 处理字段名
    $arr = explode(",",$f_name);

    $sql = "alter table $tb_name drop $arr[0]";
    $message = "删除字段";
}

// 发送sql
if(!$res){
    $res = mysqli_query($link,$sql);
}

if($res && $res1){
    echo "{$message}成功";
    header("refresh:2,url=tableInfo.php?db_name={$db_name}&tb_name={$tb_name}");
}else {
    echo "{$message}失败";
    header("refresh:2,url=tableLists.php?db_name={$db_name}");
}
?>