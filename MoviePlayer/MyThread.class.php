<?php


class MyThread extends Thread
{
    public function __construct($arg){
        $this->arg = $arg;
    }

    //当调用start方法时，该对象的run方法中的代码将在独立线程中异步执行。
    public function run(){
        if($this->arg){
            printf("Hello %s\n", $this->arg);
        }
    }
}

$thread = new test("World");

if($thread->start()) {
    //join方法的作用是让当前主线程等待该线程执行完毕
    //确认被join的线程执行结束，和线程执行顺序没关系。
    //也就是当主线程需要子线程的处理结果，主线程需要等待子线程执行完毕
    //拿到子线程的结果，然后处理后续代码。
    $thread->join();
}