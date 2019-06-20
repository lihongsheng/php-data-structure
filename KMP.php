<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-06-13
 * Time: 16:59
 */

/**
 *
 *
 * 串的存储结构：
 *
 * 串的存储结构有顺序存储结构和链式存储结构两种。
 *
 * 串的顺序存储结构：
 *
 * 与线性表的存储结构相同，可以用一个字符类型的数组存储串值。
 *
 * 在串的顺序存储结构中，由于串的长度不定，因此要使用一种方法来辨别串的长度，一种是固定设置串长度，一种是使用\0作为串的结束标志。
 *
 * 串的链式存储结构：
 *
 * 串的链式链式结构就是把串值非别存放在构成链表的若干个结点的数据域上。串的链式结构分为单字符点连和块链两种。
 *
 * 单字符链就是一个结点存储一个字符。
 *
 * 块链就是一个结点存储几个字符
 */
class char
{
    public $size = 0; //元素个数而非数组大小
    public $arr = array();
    public $maxsize = 10; //数组大小


    public function __construct($arr = array())
    {
        $this->size = count($arr);
        $this->arr  = $arr;
    }

    public function sizes()
    {
        return size;
    }

    /**
     * @param int 开始位置
     * @param string 插入的字符串
     * @return bool
     */
    public function add($start, $str)
    {
        $len = strlen($str);
        if (($start + $len) > $this->maxsize) {
            return false;//插入数据超出字符大小
        } else {
            for ($i = $this->size - 1; $i >= $len; $i--) {
                $this->arr[$i + $len] = $this->arr[$i];
            }
            for ($i = 0; $i < $len; $i++) {
                $this->arr[$start + $i] = $str{$i};
            }
            $this->size = $this->size + $len;
        }
    }

    /**  0,1,2,3,4,5,6
     *删除字符串
     * @param int 开始位置
     * @param int 删除的个数
     */
    public function delete($start, $len)
    {
        if (($start + $len) > $this->maxsize) {
            return false;
        } else {
            for ($i = $start + $len; $i <= $this->size - 1; $i++) {
                $this->arr[$i - $len] = $this->arr[$i];
            }
            $this->size = $this->size - $len;
            for ($i = $this->size - $len; $i <= $this->size - 1; $i++) {
                unset($this->arr[$i]);
            }
        }
    }

    /**  0,1,2,3,4,5,6
     *取字符串
     * @param int 开始位置
     * @param int 删除的个数
     */
    public function substr($start, $len)
    {
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $this->arr[$i + $start];
        }
        return $str;

    }

    public function getstr()
    {
        echo implode('', $this->arr);
    }


}

/**
 * Class BF
 *  Brute-Force算法
 *
 * BF算法是普通的模式匹配算法，BF算法的思想就是将目标串S的第一个字符与模式串P的第一个字符进行匹配，
 * 若相等，则继续比较S的第二个字符和P的第二个字符
 * ；若　　　　　不相等，则比较S的第二个字符和P的第一个字符，依次比较下去，直到得出最后的匹配结果。
 */
class BF
{
    public function BF($str, $t)
    {
        for ($i = 0; $i < strlen($str); $i++) {
            for ($j = 0; $j < strlen($t); $j++) {
                if ($str{$i} == $t{$j}) {
                    $i++;
                } else {
                    echo '<' . $i . '-' . $j . '>';
                    $i = $i - $j;
                    break;
                }
            }
            if ($j == strlen($t)) {
                return true;
            }
        }
        return false;
    }

    public function BF2($str, $t)
    {
        $i = $j = 0;
        while ($i < strlen($str)) {
            $j = 0;
            while ($str{$i} == $t{$j} && $j < strlen($t)) {
                $i++;
                $j++;
            }
            if ($j == strlen($t)) {
                return true;
            }
        }
        return false;
    }
}


/**
 * http://www.ruanyifeng.com/blog/2013/05/Knuth%E2%80%93Morris%E2%80%93Pratt_algorithm.html
 * https://www.jianshu.com/p/d4cf13b32111
 * Class KMP
 * 串的模式匹配
BF算法是普通的模式匹配算法，BF算法的思想就是将目标串S的第一个字符与模式串P的第一个字符进行匹配，
 * 若相等，则继续比较S的第二个字符和P的第二个字符
 * ；若　　　　　不相等，则比较S的第二个字符和P的第一个字符，依次比较下去，直到得出最后的匹配结果。
 * KMP是对 BF算法的升级
 *    主要思想是，先查找模式串中的具有相同字符串的数量及位置
 *    如果在模式串和主串中已经匹配了K个字符串，在K+1处不想等，
 *    那么这时候看看模式串中是否具有已经重复的子串，则从当前位置减去子串的字符串长度
 *    处重新查找。
 * AACdfg
 * A
 * AA
 * AAC
 * AACd
 * AACdf
 */
class KMP
{
    /**
     * 计算模式串的相同子串
     * @param $str
     * @return mixed
     */
    function getNext($str)
    {
        $k        = 0;    //前缀子串
        $j        = 1;    // 后缀子串
        $nexts[0] = -1;  //是为了匹配当一个模式字符不予串匹配时的情况
        $nexts[1] = 0;   //当第二字符不匹配时 直接比较第一个字符
        while ($j < (strlen($str)-1)) {
            //BBC ABCDAB ABCDABCDABDE
            if ($str{$j} == $str{$k}) {  //出现相同字符时
                $nexts[$j + 1] = $k + 1;
                $j++;
                $k++;
            } else {
                if ($k == 0) { //未出现相同字符 且前边也未出现相同字符时
                    $nexts[$j + 1] = 0;
                    $j++;
                } else { //前边有相同字符，依次用当前字符比较是否与以前字符相同，并记录子串的长度
                    $k = $nexts[$k];

                }
            }
        }
        return $nexts;
    }



    /**
     * KMP constructor.
     * @param $str
     * @param $t
     */
    function KMP($str, $t)
    {
        $nexts = $this->getNext($t);
        print_r($nexts);
        $i = 0;
        $j = 0;
        $k = 0;
        while ($i < strlen($str) && $j < strlen($t)) {
            $k++;
            if ($j == -1 || $str{$i} == $t{$j}) {//是为了匹配当一个模式字符不予串匹配时的情况及当$str{$i} == $t{$j}
                $i++;
                $j++;
            } else {
                //当$str{$i} ！= $t{$j} 算出 真子串中相同的部分 真子串中相同的部分不用在比较
               // echo $i . '-' . $j . '*'.PHP_EOL;
                $j = $nexts[$j];
                echo $j.PHP_EOL;
            }

            if ($j == strlen($t)) {
                return true;
            }
        }
        return false;

    }
//echo KMP("BBC ABCDAB ABCDABCDABDE","ABCDABD");

}

//var_dump( (new KMP())->getNext('abcabcaaa'));
var_dump( (new KMP())->KMP("BBC ABCDAB ABCDABCDABDE","ABCDABD"));