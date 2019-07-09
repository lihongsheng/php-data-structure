<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-07-03
 * Time: 00:29
 */

/**
 * Class Node
 */
class Node {
    public $value; //当前节点值
    public $next;  //指向的下一个节点值
}

/**
 * Class Stack
 * 栈结构可以基于链表或是数组实现。是先进后出的一种数据结构，PS有点像递归的执行流程，最后循环的先执行
 */
class Stack
{
    /**
     * @var Node
     */
    private $node;

    private $size = 0;

    public function insert($value)
    {
        $node = new Node();
        $node->value = $value;
        $node->next = null;
        if ($this->node == null) {
            $this->node = $node;
        } else {
            $node->next = $this->node;
            $this->node = $node;
        }
    }

    public function del()
    {
        $node = $this->node;
        $this->node = $this->node->next ? $this->node->next : null;
        return $node;
    }
}