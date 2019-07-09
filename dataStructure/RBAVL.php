<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-07-06
 * Time: 16:35
 */

/**
 * 定义一个树结点结构
 */
class Node
{
    public $value = null;//值

    /**
     * @var Node
     */
    public $left = null;//左子结点

    /**
     * @var Node
     */
    public $right = null;//右子结点

    /**
     * @var Node
     */

    public $parent = null; //父节点

    /**
     * @var red|black
     */
    public $color = 'r';//颜色

    public function __construct($value)
    {
        $this->value = $value;
    }

}


/**
 * Class RBAVL
 * 性质：
1.根节点是黑色
2.节点那么是红色要么是黑色，【null节点为黑色】
3.如果一个节点是红色的那么它的叶子节点必须是黑色。
1:避免了红色节点的连续行
2:黑节点可以拥有红色节点或者黑节点
4.从一个节点到null节点每一条路径必须包含相同的黑色节点
和三节点一起保正了平衡性
 */
class RBAVL
{
    /**
     * @var Node
     */
    public $root; //定义一个跟结点
    /**
     * @var Node
     */
    public $nullNode;

    /**
     * RBAVL constructor.
     * 插入分析
     * 1：新插入的节点先着色为 红色，因为为黑色的违反了性质4，从一个节点到null节点每一条路径必须包含相同的黑色节点 增加了黑色节点数目。
     *    如果插入节点的父节点是黑色插入完成，如果是红色，因为两个连续红色违反了性质三，这时候需要做旋转和重新着色已达到符合红黑树的性质。
     */

    public function __construct()
    {
        $this->nullNode = new Node();
        $this->root     = null;
    }
}