<?php

phpinfo();
exit;

class Movie_m3u8
{
    public function m3u8Download($url){
        // 获取ts文件路径前缀
        if (empty($url) || basename($url) != "index.m3u8"){
            die("m3u8文件格式错误");
        }
        $tsFilePre = substr($url,0,-strlen("index.m3u8"));

        // 创建tmp临时文件夹
        $tmpDir = "./tmp/";
        if (!file_exists($tmpDir)){
            mkdir($tmpDir);
        }

        // 获取m3u8内容
        echo "获取文件内容中...";
        $content = file_get_contents($url);

        // 获取片段
        preg_match_all('/.*\.ts/', $content, $matches);
        if (empty($matches)){
            // m3u8地址错误
            die('m3u8 文件格式错误');
        }

        //下载所有的ts碎片到./tmp文件夹下
        $tsFiles = $matches[0];
        $count = count($tsFiles);
        echo "共{$count}个ts碎片<br/>";
        foreach ($tsFiles as $k=>$v){
            $tsFileName = $tmpDir.$v;
            if (!file_exists($tsFileName)){
               $tsContent = file_get_contents($tsFilePre.$v);
                file_put_contents($tsFileName,$tsContent);
            }
        }

        // 合并ts文件
        $mp4FileName = $tmpDir."movie.mp4";
        foreach ($tsFiles as $k => $v) {
            echo "正在合并第{$k}个ts文件<br>";
            $tsFilePath = $tmpDir.$v;
            file_put_contents($mp4FileName,file_get_contents($tsFilePath),FILE_APPEND);

            // 删除ts文件
            unlink($tsFilePath);
        }

        echo "下载完成";
    }
}


$m3u8 = new Movie_m3u8();
$m3u8 -> m3u8Download('http://ww2w.243xw.cn:32512/video/m3u8/2019/09/10/a792a7f5/index.m3u8');