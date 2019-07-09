<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-07-02
 * Time: 23:52
 */

/**
 * Class Node
 */
class Node {
    public $value; //当前节点值
    public $next;  //指向的下一个节点值
}


/**
 * Class TableManage
 */
class TableManage{

    /**
     * @var Node
     */
    private $node;

    private $size = 0;

    /**
     * @param $value
     */
    public function insert($value)
    {
        $node = new Node();
        $node->value = $value;
        $node->next = null;
        $lastNode  = null;
        $this->size++;
        if ($this->node === null) {
           $this->node = $node;
           $this->size++;
        } else {
            $lastNode = $this->node;
            while ($lastNode->next && ($lastNode = $lastNode->next));
            $lastNode->next = $node;
        }
    }

    /**
     * @param $value
     * @return bool
     */
    public function del($value)
    {
        if ($this->node !== null) {
            $lastNode = $preNode = $this->node;
            while ($lastNode && $lastNode->value != $value ) {
                $preNode  = $lastNode;
                $lastNode = $lastNode->next;
            }
            if (!$lastNode) {
                return false;
            } else {
                $this->size--;
                $preNode == $this->node ? $this->node = null : $preNode->next = $lastNode->next;
            }

        }

        return false;

    }

    public function getSize()
    {
        return $this->size;
    }
}