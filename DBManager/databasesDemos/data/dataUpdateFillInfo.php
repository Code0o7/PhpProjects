<?php
###################################
#修改数据 填写信息
###################################

// 获取传过来的数据

// 数据库名
$db_name = $_GET["db_name"];
$tb_name = $_GET["tb_name"];

// 修改的数据
$data = unserialize(base64_decode($_GET["data"]));

var_dump($data);

// 条件
$condition = "";
foreach($data as $k=>$v){
    if(!empty($k) && !empty($v)){
        $condition = "{$k}={$v}";
        break;
    }
}

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
    <form action="dataUpdateCommit.php" method="post">
        <table class="tb-list" cellspacing="1" cellpadding="8">
        <caption align="center"><?php echo "修改{$db_name}数据库里{$tb_name}表的数据"?></caption>
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
                            <input id="man" type="radio" name="sex" value="1" />男
                            <input id="woman" type="radio" name="sex" value="0" />女
                        <?php else:?>
                            <input 
                                type="text" 
                                name=<?php echo $content?> placeholder=<?php echo "请输入{$co}"?> 
                                value=<?php echo $data[$content]?>
                            />
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
        <input id="condition" type="hidden" name="condition" />
    </form>
</body>
</html>
<script>
    window.onload = function(){
        var db_name = '<?php echo $db_name?>';
        var tb_name = '<?php echo $tb_name?>';

        document.getElementById("db_name").setAttribute("value",db_name);
        document.getElementById("tb_name").setAttribute("value",tb_name);

        var condition = '<?php echo $condition?>';
        document.getElementById("condition").setAttribute("value",condition);

        var man = document.getElementById("man");
        var woman = document.getElementById("woman");
        var sex = '<?php echo $data["sex"]?>';
        if(sex == "1"){
            man.setAttribute("checked","checked");
        }else {
            woman.setAttribute("checked","checked");
        }

    }
</script>