<?php
// 获取服务器支持的编码方式列表

// 连接数据库
$link = mysqli_connect("localhost","root","");

// sql语句
$sql = "show charset";
// 发送sql语句
$res = mysqli_query($link,$sql);
// 解析结果
$rows = array();
$default_index = 0;
while($row = mysqli_fetch_assoc($res)){
    $rows[] = $row;

    // 获取utf8编码索引值，方便后面设置默认选中编码为utf8
    if($row["Charset"] == 'utf8'){
        $default_index = count($rows) - 1;
    }
}

// 获取标识 1标识修改数据库 2标识添加数据库
$flag = $_GET["flag"];

// 获取修改数据库时数据库名
$name = isset($_GET["name"]) ? $_GET["name"] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新建数据库</title>
    <link rel="stylesheet" type="text/css" href="../myStyles.css" />
    <style type="text/css">
        input{
            margin: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <form id="form" action="./dataBaseAddCommit.php" method="post">
        <table>
            <tr>
                <td>数据库名:</td>
                <td>
                    <input type="text" id="db_name" name="name" placeholder="请输入数据库名"/>
                    <br/>
                </td>
            </tr>
            <tr>
                <td>Charset:</td>
                <td>
                    <select id="charset" name="charset">
                        <?php foreach($rows as $value):?>
                        <option><?php echo $value["Charset"]?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Default collation:</td>
                <td>
                    <select id="collation" disabled="" name="collation">
                    <?php foreach($rows as $value):?>
                        <option><?php echo $value["Default collation"]?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="提交"/>
                </td>
            </tr>
        </table>
        <input type="hidden" name="flag" value=<?php echo $flag;?>/>
    </form>
</body>
</html>
<script>
    window.onload = function(){
        var flag = '<?php echo $flag?>';
        if(flag == '1'){
            // 如果是修改数据库 显示数据库原有的名字 且不能修改
            var db_name = '<?php echo $name;?>';
            document.getElementById("db_name").setAttribute("value",db_name);
            document.getElementById("db_name").setAttribute("disabled","disabled");
        }
        

        // 默认选中utf8
        var default_select_index = '<?php echo $default_index;?>';

        // charset select
        var charset_select = document.getElementById("charset");
        charset_select.options[default_select_index].selected = true;
        

        // Default collation select
        var collation_select = document.getElementById("collation");
        collation_select.options[default_select_index].selected = true;
        // 设置Default collation选择框不能被修改

        // charset选择改变
        charset_select.onchange = function(){
            var selectIndex = this.selectedIndex;

            // 设置Default collation选择框联动改变
            collation_select.options[selectIndex].selected = true;
        }

        // 监听表单提交
        var form = document.getElementById('form');
        form.onsubmit = function(){
            // 开启Default collation选择框的disable属性，否则数据不能提交到php文件
            collation_select.removeAttribute("disabled");

            document.getElementById("db_name").removeAttribute("disabled");
        }
    }
</script>