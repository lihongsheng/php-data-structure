<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-06-19
 * Time: 15:49
 *
 * 冒泡 排序
 */

class BubbleSort
{
    /**
     * @param array $arr
     * @return array
     * 冒泡的主要思想是：
     *    依次 以前一个位置的值，往后一一比较，如果前边的值大于后边的值，则置换两个位置的值。依次重复直到比较完毕。
     *    第一次 比较会把最小值放到前边，依次放入第二个最小值。。
     */
    public function bubbleSort(array $arr)
    {

        $i = 0;
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = $i + 1; $j < count($arr); $j++) {
                if ($arr[$j] < $arr[$i]) {
                    $tmp     = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }

        return $arr;
    }

    /**
     * @param $arr
     * 插入排序：
     *    主要思想类似与扑克牌：依据前边的数字两两比较。进行置换
     */
    public function insertionSort($arr)
    {
        if (count($arr) <= 1) {
            return;
        }
        for ($i = 0; $i < count($arr); $i++) {
            $tmp = $arr[$i];
            for ($j = $i; $j > 0 && $arr[$j - 1] > $tmp; $j--) {
                $arr[$j] = $arr[$j - 1]; //交换值
            }
            $arr[$j] = $tmp; //最后一次移位后赋值
        }

        return $arr;
    }


    /**
     * 归并排序
     * @param array $testArr
     * @param array $tmpArr
     * @param $left
     * @param $right
     * @return array
     * 主要思想是：
     *    分治思想：主要递归处理，因为递归是回溯的最后一层的先执行，所以到最后是类似于俩俩比较，然后合并数组。
     */
    public function mergeSort(array &$testArr, array $tmpArr, $left, $right)
    {
        if ($left < $right) {
            $mid = (int)(($left + $right) / 2);
            $this->mergeSort($testArr, $tmpArr, $left, $mid);
            $this->mergeSort($testArr, $tmpArr, $mid + 1, $right);
            $this->merge($testArr, $tmpArr, $left, $mid + 1, $right);//归并数组
        }

        return $testArr;
    }

    /**
     * @param $testArr
     * @param $tmpArr
     * @param $left
     * @param $mid
     * @param $right
     * @return array
     */
    public function merge(&$testArr, $tmpArr, $left, $mid, $right)
    {
        $leftEnd = $mid - 1;
        $tmpPos  = $left;
        $num     = $right - $left + 1;
        $r       = $right;
        //echo $left .'-'.$mid.'-'.$right.PHP_EOL;

        while ($left <= $leftEnd && $mid <= $right) {

            /**
             * 左右数组对比
             */
            if ($testArr[$left] <= $testArr[$mid]) {
                $tmpArr[$tmpPos++] = $testArr[$left++];
            } else {
                $tmpArr[$tmpPos++] = $testArr[$mid++];
            }
        }

        /**
         * 左数组未跑完的
         */
        while ($left <= $leftEnd) {
            $tmpArr[$tmpPos++] = $testArr[$left++];
        }
        /**
         * 右数组未跑完的
         */
        while ($mid <= $right) {
            $tmpArr[$tmpPos++] = $testArr[$mid++];
        }

        /**
         * 回归原始的位置
         */
        for ($i = 0; $i < $num; $i++, $right--) {
            $testArr[$right] = $tmpArr[$right];
        }

        return $testArr;
    }


    /**
     * @param $arr
     * @param $left
     * @param $right
     * @return bool
     */
    public function quickSort($arr, $left, $right)
    {
        if ($left === $right) {
            return false;
        }
        $tmp    = '';
        $i      = $j = 0;
        $center = (int)(($left + $right) / 2);
        $this->quickSort($arr, $left, $center);
        $this->quickSort($arr, $center + 1, $right);
        for ($i = $left; $i < $right; $i++) {
            //$arr[$i-1],$arr[$i-2]...$arr[$i-n]相互之间比较
            for ($j = $i; $j > 0 && ($arr[$j - 1] >= $arr[$j]); $j--) {
                $tmp         = $arr[$j];
                $arr[$j]     = $arr[$j - 1];
                $arr[$j - 1] = $tmp;

            }
        }
        return $arr;
    }


    /**
     * @param $arr
     * @param $left
     * @param $right
     */
    public function quickSort2($arr, $left, $right)
    {
        $mid  = $arr[$left];
        $low  = $left;
        $high = $right;
        while ($left < $right) {
            //从右往左扫描
            while ($left < $right && $mid <= $arr[$right]) {
                $right--;
            }
            //出循环 说明 在 当前right处的值小于 左边的值 所以交换值
            if ($left < $right) {
                $arr[$left] = $arr[$right];
                $left++;
            }

            while ($left < $right && $arr[$left] < $mid) {
                $left++;
            }
            if ($left < $right) {
                $arr[$right] = $arr[$left];
                $right--;
            }
        }
        $arr[$left] = $mid;
        if ($low < $left) {
            $this->quickSort2($arr, $low, $left - 1);
        }
        if ($right > $low) {
            $this->quickSort2($arr, $right + 1, $high);
        }
    }


    /**
     * 左右一起扫描
     * @param $arr
     * @param $left
     * @param $right
     * @return mixed
     */
    public function quick(&$arr, $left, $right)
    {
        if ($left < $right) {
            $center = $this->quickSort3($arr, $left, $right);
            $this->quick($arr, $left, $center);
            $this->quick($arr, $center + 1, $right);
        }
        return $arr;
    }

    /**
     * @param $arr
     * @param $left
     * @param $right
     * @return int
     */
    public function quickSort3(&$arr, $left, $right)
    {
        $mid       = $arr[$left];
        $leftStart = $left;
        while (true) {
            while ($leftStart <= $right && $arr[$leftStart] <= $mid) {
                $leftStart++;
            }

            while ($leftStart <= $right && $arr[$right] >= $mid) {
                $right--;
            }

            if ($leftStart >= $right) {
                break;
            }

            $tmp             = $arr[$leftStart];
            $arr[$leftStart] = $arr[$right];
            $arr[$right]     = $tmp;
        }
        $arr[$left]  = $arr[$right];
        $arr[$right] = $mid;

        return $right;
    }
}

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
//var_dump((new BubbleSort())->sort($testArr));
//var_dump((new BubbleSort())->insertionSort($testArr));
//var_dump((new BubbleSort())->mergeSort($testArr, [],0, 10));
var_dump((new BubbleSort())->quick($testArr, 0, 10));


