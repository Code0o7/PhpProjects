<?php
###################################
#添加数据 填写信息
###################################

// 获取传过来的数据

// 数据库名
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];

// 连接数据库
$link = mysqli_connect("localhost","root","",$db_name);

// 查询表结构sql语句
// $sql1 = "desc $tb_name";
$sql1 = "show full columns from $tb_name";

// 执行sql
$res1 = mysqli_query($link,$sql1);

// 解析结果
$rows1 = array();
while($row = mysqli_fetch_assoc($res1)){
    if(isset($row["Extra"]) && $row["Extra"] != "auto_increment"){
        $rows1[] = $row;
    }
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
        span.tit{
            font-size: 18px;
            font-weight: bold;
        }

        span.lit{
            color:#ccc;
            font-size: 12px;
        }

        .commit{
            width: 172px;
            height: 40px;
            margin: -30px auto;
        }
    </style>
</head>
<body>
    <form action="dataAddCommit.php" method="post">
        <table class="tb-list" cellspacing="1" cellpadding="8">
        <caption align="center"><?php echo "给{$db_name}数据库里的{$tb_name}表添加数据"?></caption>
            <?php foreach($rows1 as $value):?>
                <tr>
                    <td align="center">
                        <?php 
                            $content = $value["Field"];
                            $tp = $value["Type"];
                            $co = $value["Comment"];
                            echo "<span class='tit'>{$content}</span>";
                            echo "<br />";
                            echo "<span class='lit'>{$tp}</span>";
                            echo "<br />";
                            echo "<span class='lit'>{$co}</span>";
                        ?>
                    </td>
                    <td>
                        <?php if($value["Field"] == "sex"):?>
                            <input type="radio" name="sex" value="1" checked="checked"/>男
                            <input type="radio" name="sex" value="0" />女
                        <?php else:?>
                            <input type="text" name=<?php echo $content?> placeholder=<?php echo "请输入{$co}"?> />
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
        <div class="commit">
            <input type="submit" value="提交" />
        </div>
        <input id="db_name" type="hidden" name="db_name" />
        <input id="tb_name" type="hidden" name="tb_name" />
    </form>
</body>
</html>
<script>
    window.onload = function(){
        var db_name = '<?php echo $db_name?>';
        var tb_name = '<?php echo $tb_name?>';

        document.getElementById("db_name").setAttribute("value",db_name);
        document.getElementById("tb_name").setAttribute("value",tb_name);
    }
</script>