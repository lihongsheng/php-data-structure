<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-07-03
 * Time: 16:15
 */

class Node {
    public $value = null;//值

    /**
     * @var Node
     */
    public $left = null;//左子结点

    /**
     * @var Node
     */
    public $right = null;//右子结点

    public function __construct($value)
    {
        $this->value = $value;
    }


}

class BinaryTree
{
    /**
     * @var Node
     */
    public $node;

    public function __construct()
    {
    }

    /**
     * @param $value
     */
    public function insert($value)
    {
        if ($this->node == null) {
            $this->node = new Node($value);
        } else {
            $parent = $link = $this->node;
            while ($link != null) {
                //找到插入点的上层节点
                $parent = $link;
                if ($link->value > $value) {
                    $link = $link->left;
                } else {//if ($link->value < $value)
                    $link = $link->right;
                }
            }


            //判断插入左边还是右边

            if ($parent->value > $value) {
                $parent->left = new Node($value);
            } else {//else if($parent->value  $value)
                $parent->right = new Node($value);
            }

        }
    }

    /**
     * 无孩子节点，有左右孩子节点，只有做孩子或者右孩子节点，还有考虑所处于的父节点那个位置。当有左右孩子节点的时候还要考虑到二叉树的性质做节点的链式结构的改变，所以这种类型的节点要删除，如果直接删，真个树的大小顺序就乱了，所以需要考虑，在树中找到一个合适的节点来把这个节点
    给替换掉，用这种方法来保持整个数的稳定。所以又一个问题又来了了，该找哪个节点来替换它？结论是，需要在树中找出所有比
    被删除节点的值大的所有数，并在这些数中找出一个最小的数来。听起来很拗，如果把它用图形来描述的话，就是，从被删除的节点出发
    经过它的右节点，然后右节点最左边的叶子节点就是我们要找的，它有一个专业名词叫中序后继节点。
     * @param $val
     * @return bool
     */
    public function del($val)
    {
        if($this->node == null) {
            return false;
        }
        $parent = $link = $this->node;

        if ($parent->left == null && $parent->right == null) {
            $this->node = null;
            return $parent;
        }
        $find = 0;
        while ($link) {
            if ($link->value > $val) {
                $parent = $link;
                $link = $link->left;
            }
            if ($link->value < $val) {
                $parent = $link;
                $link = $link->right;
            }
        }
        //删除节点左右子节点都存在
        if ($link->left && $link->right) {

           $sonParent = $link;
            //找到右子树最小的节点。
           while ($link->left) {
               $sonParent = $link;
               $link = $link->left;
           }
           $sonParent->left = $link->right;
           //当前节点替换为右子树的最小节点
             if ($parent->left == $link) {
                $parent->left = $link;
            }
            if ($parent->right == $link) {
                $parent->right = $link;
            }
        }

        // 左右子节点不存在
        if ($link->left == null && $link->right == null) {
            if ($parent->left == $link) {
                $parent->left = null;
            }
            if ($parent->right == $link) {
                $parent->right = null;
            }
        }

        if ($link->left && $link->right) {

        }

    }


    /**
     * @param Node $node
     * @return Node|null
     */
    public function findMin(Node $node)
    {
        while ($node->left) {
            $node = $node->left;
        }
        return $node;
    }


    /**
     * @param Node $node
     * @return Node|null
     */
    public function findMax(Node $node)
    {
        while ($node->right) {
            $node = $node->right;
        }
        return $node;
    }


    /**
     * @param Node $node
     * @param $value
     * @return Node|null
     */
    public function delRecursion(Node $node, $value)
    {
        if ($value > $node->value) {
            $node->right = $this->delRecursion($node->right, $value);
        } else if ($value < $node->value) {
            $node->left = $this->delRecursion($node->left, $value);
        } else {
            if ($node->left && $node->right) {
                $tmp = $this->findMin($node->right);
                $node->value = $tmp->value;
                $node->right = $this->delRecursion($node->right, $tmp->value);
            } else if ($node->left || $node->right) {
                $node = $node->left ? $node->left : $node->right;
            } else {
                $node = null;
            }

        }

        return $node;
    }


    /**
     * 先序遍历
     *    先访问根节点，在访问左子树，在访问右子树
     *   中序是先访问左子树, 再根结点，再右子树,
     *   后序是先访问左子树, 再右子树，再根结点
     */
    function printTreeOne(Node $node, $space = "")
    {
        if ($node) {
            echo $space . $node->value . PHP_EOL;
            $this->printTreeOne($node->left, $space . "    ");
            $this->printTreeOne($node->right, $space . "    ");
        }
    }

    /**
     * 层次遍历：可以顺序访问节点
     *    依据与队列或是栈来存储要遍历的节点
     *    可以达到顺序取数据的目的
     */
    public  function printTree2(Node $node)
    {
        $tmp[] = $node;
        while (!empty($tmp)) {
           $node = array_shift($tmp);
           echo $node->value.PHP_EOL;
            if ($node->left) {
                array_push($tmp, $node->left);
            }
            if ($node->right) {
                array_push($tmp, $node->right);
            }
        }
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

$obj = new BinaryTree();
foreach ($testArr as $a) {
    $obj->insert($a);
}

$obj->printTree2($obj->node);