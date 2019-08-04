<?php
// class Scheduler {
//    protected $maxTaskId = 0;
//    protected $taskMap = []; // taskId => task
//    protected $taskQueue;
//
//
//
//
//
//    public function __construct() {
//        $this->taskQueue = new SplQueue();
//    }
//
//    public function newTask(Generator $coroutine) {
//        $tid = ++$this->maxTaskId;
//        $task = new Task($tid, $coroutine);
//        $this->taskMap[$tid] = $task;
//        $this->schedule($task);
//        return $tid;
//    }
//
//    public function schedule(Task $task) {
//        $this->taskQueue->enqueue($task);
//    }
//
//    public function run() {
//        while (!$this->taskQueue->isEmpty()) {
//            $task = $this->taskQueue->dequeue();
//            $task->run();
//            echo "task is contuine\n";
//            if ($task->isFinished()) {
//                unset($this->taskMap[$task->getTaskId()]);
//            } else {
//                $this->schedule($task);
//            }
//        }
//    }
//}
//
//
//class Task {
//    protected $taskId;
//    protected $coroutine;
//    protected $sendValue = null;
//    protected $beforeFirstYield = true;
//
//    public function __construct($taskId, Generator $coroutine) {
//        $this->taskId = $taskId;
//        $this->coroutine = $coroutine;
//    }
//
//    public function getTaskId() {
//        return $this->taskId;
//    }
//
//    public function setSendValue($sendValue) {
//        $this->sendValue = $sendValue;
//    }
//
//    public function run() {
//        if ($this->beforeFirstYield) {
//            $this->beforeFirstYield = false;
//            return $this->coroutine->current();
//        } else {
//            $retval = $this->coroutine->send($this->sendValue);
//            $this->sendValue = null;
//            return $retval;
//        }
//    }
//
//    public function isFinished() {
//        return !$this->coroutine->valid();
//    }
//}


//function sleep2($task) {
//    echo $task.":::\n";
//    sleep(3);
//    //file_put_contents('/tmp/TEST.TXT',date('Y-m-d H:i:s').$task."\n",FILE_APPEND);
//    yield file_get_contents("https://www.baidu.com");
//}
//
//function task1() {
//    for ($i = 1; $i <= 10; ++$i) {
//        echo "This is task 1 iteration $i.\n";
//        $task = 'task1 '.$i;
//        yield sleep2($task);
//      //  yield $task;
//    }
//}
//
//function task2() {
//    for ($i = 1; $i <= 5; ++$i) {
//        echo "This is task 2 iteration $i.\n";
//        $task = 'task2 '.$i;
//        yield sleep2($task);
//    }
//}
 



//var_dump(task1()->current()->current());//







//function fib($n)
//{
//    $cur = 1;
//    $prev = 0;
//    //for ($i = 0; $i < $n; $i++) {
//        yield $cur;
//
//        // 在yield处中断一次，
//        //     调用next继上次中断处执行
//        //     调用current 获取当期yield处的值 继续中断
//
//
//        $temp = $cur;
//        $cur = $prev + $cur;
//        $prev = $temp;
//        echo ":yield后边的代码也执行了:".$cur."";
//        yield ++$cur;
//       /* $temp = $cur;
//        $cur = $prev + $cur;
//        $prev = $temp;*/
//       echo ":::::::".PHP_EOL;
//        //var_dump($cur);
//    //}
//}
//
//$fibs = fib(9);
//var_dump($fibs->send(2));
//var_dump($fibs->current());
//$fibs->next();
//$fibs->next();
// foreach ($fibs as $fib) {
//     echo  $fib;
// }
// echo $fibs->current().PHP_EOL; // int(1)
// $fibs->next();echo PHP_EOL;//":yield后边的代码也执行了:1";
// echo $fibs->current().PHP_EOL; //<<<<<<<<<<<:::::::::>>>>>>>>>>>>
// $fibs->next();echo PHP_EOL; //$cur = $prev + $cur;
// echo $fibs->current().PHP_EOL;//2
//
//
// function sendAndGet()
// {
//    $str = (yield );
//    var_dump($str);
//    //yield $str;
// }
//
// sendAndGet();
//$str = sendAndGet();
//var_dump($str->send(90));
////echo $str->current();
//
//
//echo PHP_EOL.PHP_EOL.PHP_EOL;
//
//function gen() {
//    $ret = (yield 'yield1');
//    var_dump($ret);
//    $ret = (yield 'yield2');
//    var_dump($ret);
//}
//
//$gen = gen();
//var_dump($gen->current());    // string(6) "yield1" 在59行
//var_dump($gen->send('ret1')); // string(4) "ret1"   (the first var_dump in gen) 在53行
//                              // string(6) "yield2" (the var_dump of the ->send() return value) 在60
//var_dump($gen->send('ret2')); // string(4) "ret2"   (again from within gen) 在55
//                              // NULL               (the return value of ->send()) 在62行

//echo PHP_EOL.PHP_EOL.PHP_EOL;
//
//function gen() {
//
//        $ret = (yield 'yield1');
//        var_dump($ret);
//
//    $ret = (yield 'yield2');
//    var_dump($ret);
//}
//
//$gen = gen();
//var_dump($gen->current());    // string(6) "yield1"
//var_dump($gen->send('ret1')); // string(4) "ret1"   (the first var_dump in gen)
// //string(6) "yield2" (the var_dump of the ->send() return value)
//var_dump($gen->send('ret2')); // string(4) "ret2"   (again from within gen)
//// NULL               (the return value of ->send())


class TestIterator implements Iterator
{
    private $index = 0;

    private $value = 0;


    public function __construct()
    {
        $this->index = 0;
    }


    public function current()
    {
        echo ":::".__METHOD__."::::".PHP_EOL;
        return $this->value;
    }


    public function next()
    {
        echo ":::".__METHOD__."::::".PHP_EOL;
        $this->value++;
        $this->index++;
    }


    public function rewind()
    {
        echo ":::".__METHOD__."::::".PHP_EOL;
        $this->index = 0;
        $this->value = 0;
    }


    public function key()
    {
        echo ":::".__METHOD__."::::".PHP_EOL;
        return $this->index;
    }

    public function valid()
    {
        echo ":::".__METHOD__."::::".PHP_EOL;
        return true;
    }
}

$it = new TestIterator();
echo "*********************";
$index = 0;
foreach ($it as $value) {
    if ($index > 5) {
        break;
    }
    echo PHP_EOL.PHP_EOL;
    $index++;
    echo "VALUE::".$value;
}