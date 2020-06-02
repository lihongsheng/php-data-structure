<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2020-02-10
 * Time: 16:37
 *   用于获取在N多数据中取Top K数据
 * Class Heap
 * @package App\Libs
 */
namespace App\Libs;

class Heap
{
    /**
     * 存储的最大值
     * @var int
     */
    private $maxSize;

    private $heapArr = [];

    protected $heapSize = -1;

    /**
     * Heap constructor.
     * @param $maxSize
     */
    public function __construct($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     *
     */
    public function getAllData()
    {
        return $this->heapArr;
    }

    /**
     * @param $val
     *
     */
    public function add(array $val)
    {
        $this->heapSize++;
        if ($this->heapSize == $this->maxSize) {
            if ($val['score'] > $this->heapArr[0]['score']) {
                //达到最大值时候弹出最小数
                $this->delete();
            } else {
                $this->heapSize--;
                return;
            }
        }

        $this->heapArr[$this->heapSize] = $val;
        //$i = (count($this->heapArr) - 1);
        $i = $this->heapSize;
        while ($i >= 0) {
            $j = ($i - 1) / 2;
            if ($j >= 0 && $this->heapArr[$i]['score'] < $this->heapArr[$j]['score']) {
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
     * 弹出一个值
     */
    public function delete()
    {
        $i       = (count($this->heapArr) - 1);
        $minVal  = $this->heapArr[0];
        $lastVal = $this->heapArr[$i];
        $j       = 0;
        while (2 * $j < ($i - 1)) {
            $left  = 2 * $j + 1;
            $right = 2 * $j + 2;
            $t     = $left;
            if ($this->heapArr[$left]['score'] && $this->heapArr[$right]['score'] && $this->heapArr[$right]['score'] < $this->heapArr[$left]['score']) {
                $t = $right;
            }
            if ($lastVal['score'] > $this->heapArr[$j]['score']) {
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
     * 排序
     * @param string $order asc|desc
     */
    private function bubbleSort($order = 'desc')
    {
        $i = 0;
        for ($i = 0; $i < count($this->heapArr); $i++) {
            for ($j = $i + 1; $j < count($this->heapArr); $j++) {
                $bool = false;
                if ($order === 'desc' && $this->heapArr[$j]['score'] > $this->heapArr[$i]['score']) {
                    $bool = true;
                }
                if ($order === 'asc' && $this->heapArr[$j]['score'] < $this->heapArr[$i]['score']) {
                    $bool = true;
                }
                if ($bool) {
                    $tmp     = $this->heapArr[$i];
                    $this->heapArr[$i] = $this->heapArr[$j];
                    $this->heapArr[$j] = $tmp;
                }
            }
        }

    }

    public function getDescSortData()
    {
        $this->bubbleSort("desc");
        return $this->heapArr;
    }

    public function getAscSortData()
    {
        $this->bubbleSort("asc");
        return $this->heapArr;
    }

}