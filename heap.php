<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-06-18
 * Time: 10:38
 */

/**
 * Class heap
 * 二叉堆【优先级队列】
 * 二叉堆的定义是：父节点的键值总是不大于它的孩子节点的键值（小顶堆）, 堆可以分为小顶堆和大顶堆。
 *     在数组中i处的左子节点为 2 * i + 1 右子节点在 2 * i + 2，子节点的父节点在 （i-1）/2处
 */
class heap
{
    public $heapArr = [];
    protected $heapSize = -1;

    /**
     * @param $testArr
     *
     */
    public function init($testArr)
    {

    }

    /**
     * @param $val
     */
    public function insert($val)
    {
        $this->heapSize++;
        $this->heapArr[$this->heapSize] = $val;
        $i                              = (count($this->heapArr) - 1);
        while ($i >= 0) {
            $j = ($i - 1) / 2;
            if ($j >= 0 && $this->heapArr[$i] < $this->heapArr[$j]) {
                $tmp               = $this->heapArr[$i];
                $this->heapArr[$i] = $this->heapArr[$j];
                $this->heapArr[$j] = $tmp;
                $i                 = $j;
            } else {
                break;
            }
        }
    }

    /**
     *
     */
    public function delete()
    {
        $i       = (count($this->heapArr) - 1);
        $minVal  = $this->heapArr[0];
        $lastVal = $this->heapArr[$i];
        $j       = 0;
        while (2 * $j <= $i) {
            $left  = 2 * $j + 1;
            $right = 2 * $j + 2;
            $t     = $left;
            if ($this->heapArr[$left] && $this->heapArr[$right] && $this->heapArr[$right] < $this->heapArr[$left]) {
                $t = $right;
            }
            if ($lastVal > $this->heapArr[$j]) {
                $this->heapArr[$j] = $this->heapArr[$t];
                $j                 = $t;
            } else {
                break;
            }
        }
        $this->heapArr[$j] = $lastVal;
        unset($this->heapArr[$i]);
        $this->heapSize--;
        return $minVal;
    }


    /**
     * @param array $arr
     * @return array
     */
    public function sort(array $arr)
    {
        //构建二叉堆
        $length = count($arr);
        for ($i = ($length - 2) / 2; $i >= 0; $i--) {
            $arr = $this->down($arr, $i, $length);
        }
        var_dump($arr);
        //进行堆排序
        for ($i = $length - 1; $i >= 1; $i--) {
            //把堆顶的元素与最后一个元素交换
            $temp    = $arr[$i];
            $arr[$i] = $arr[0];
            $arr[0]  = $temp;
            //下沉调整
            $arr = $this->down($arr, 0, $i);
        }
        return $arr;
    }

    /**
     * @param array $arr
     * @param int $parent
     * @param int $length
     * @return array
     */
    public function down(array $arr, int $parent, int $length)
    {
        //临时保证要下沉的元素
        $temp = $arr[$parent];
        //定位左孩子节点位置
        $child = 2 * $parent + 1;
        //开始下沉
        while ($child < $length) {
            //如果右孩子节点比左孩子小，则定位到右孩子
            if ($child + 1 < $length && $arr[$child] > $arr[$child + 1]) {
                $child++;
            }
            //如果父节点比孩子节点小或等于，则下沉结束
            if ($temp <= $arr[$child]) {
                break;
            }
            //单向赋值
            $arr[$parent] = $arr[$child];
            $parent       = $child;
            $child        = 2 * $parent + 1;
        }
        $arr[$parent] = $temp;
        return $arr;
    }


    function myHash($str) {
        // hash(i) = hash(i-1) * 33 + str[i]
        $hash = 5381;
        $s    = md5($str); //相比其它版本，进行了md5加密
        $seed = 5;
        $len  = 32;//加密后长度32
        for ($i = 0; $i < $len; $i++) {
            // (hash << 5) + hash 相当于 hash * 33
            //$hash = sprintf("%u", $hash * 33) + ord($s{$i});
            //$hash = ($hash * 33 + ord($s{$i})) & 0x7FFFFFFF;
            $hash = ($hash << $seed) + $hash + ord($s{$i});
        }

        return $hash & 0x7FFFFFFF;
    }


    /**
     * @param $data
     * @param $pId
     * @return array
     */
    public function getTree($data, $pId)
    {
        $tree = array();
        foreach($data as $k => $v)
        {
            if($v['parentid'] == $pId)
            {        //父亲找到儿子
                $v['parentid'] = $this->getTree($data, $v['id']);
                $tree[] = $v;

            }
        }

        return $tree;

    }


}

$array =  array(
    1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
    2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
    3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
    4 => array('id'=>'4','parentid'=>0,'name'=>'一级栏目一'),
    5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目二'),
    6 => array('id'=>'6','parentid'=>5,'name'=>'三级栏目一'),
    7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目一'),
    8 => array('id'=>'8','parentid'=>7,'name'=>'四级栏目二'),
    9 => array('id'=>'9','parentid'=>1,'name'=>'二级栏目一'),
    10 => array('id'=>'10','parentid'=>7,'name'=>'一级栏目一'),
    11 => array('id'=>'11','parentid'=>2,'name'=>'二级栏目二')
);

$testArr = [
    31,
    21,
    19,
    68,
    26,
    65,
    19,
    14,
    13,
    16,
    32
];

$heap = new heap();

/*foreach ($testArr as $val) {
    $heap->insert($val);
}*/

//var_dump($heap->heapArr);

echo json_encode($heap->getTree($array,0));
//var_dump($heap->heapArr);