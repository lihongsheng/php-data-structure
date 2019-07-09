<?php
/**
 * Created by PhpStorm.
 * User: lhs
 * Date: 2019-07-05
 * Time: 13:21
 */

/**
 * 平衡树
 *
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
    public $parent;

    /**
     * @var int
     */
    public $height = 0;//高度

    public function __construct($value)
    {
        $this->value = $value;
    }


}


/**
 * Class AvlTree
 */
class AvlTree
{

    /**
     * @param Node $node
     * @return int
     */
    public function getHeight($node)
    {
        if ($node == null) {
            return -1;
        } else {
            return $node->height;
        }
    }

    /**
     * @param Node $node
     * @return Node
     */
    public function leftSigon(Node $node)
    {
        /**
         * @var Node $k1 ;
         */
        $k1           = $node->left;//也即是 4 节点
        $node->left   = $k1->right;
        $k1->right    = $node;
        $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;
        $k1->height   = max($this->getHeight($k1->left), $this->getHeight($k1->right)) + 1;
        return $k1;
    }

    /**
     * @param Node $node
     * @return Node
     */
    public function rightSigon(Node $node)
    {
        /**
         * @var Node $k1 ;
         */
        $k1          = $node->right;//也即是 8 节点
        $node->right = $k1->left;//父节点的右节点为子节点的做节点【二叉树定义可知 右子树大于父节点，所以右子树下的左节点作为父节点的右子树】
        $k1->left    = $node;//右子树的做节点为父节点，转换完毕
        //重新计算 高度因子值
        $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;
        $k1->height   = max($this->getHeight($k1->left), $this->getHeight($k1->right)) + 1;
        return $k1;
    }

    public function LRSigon(Node $node)
    {
        $node->left = $this->rightSigon($node->left);
        return $this->leftSigon($node);
    }

    /**
     * @param Node $node
     * @return mixed
     */
    public function RLSigon(Node $node)
    {
        $node->right = $this->leftSigon($node->right);
        return $this->rightSigon($node);
    }


    /**
     * @param $x
     * @param Node $node
     * @return Node
     */
    public function insert($x, $node)
    {
        if ($node == null) {
            $node         = new Node($x);
            $node->left   = $node->right = null;
            $node->height = 0;
        } else if ($x < $node->value) {
            $node->left = $this->insert($x, $node->left);
            if ($this->getHeight($node->left) - $this->getHeight($node->right) == 2) {
                if ($x < $node->left->value) {
                    $node = $this->leftSigon($node);
                } else {
                    $node = $this->LRSigon($node);
                }
            }
        } else if ($x > $node->value) {
            $node->right = $this->insert($x, $node->right);
            if ($this->getHeight($node->right) - $this->getHeight($node->left) == 2) {
                if ($x > $node->right->value) {
                    $node = $this->rightSigon($node);
                } else {
                    $node = $this->RLSigon($node);
                }
            }
        }

        $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;
        return $node;
    }

    /**
     * @param $node
     * @param $space
     */
    public function printTree($node, $space = '')
    {
        if ($node) {
            echo $space . $node->value . "[" . $node->height . "]" . PHP_EOL;
            $this->printTree($node->left, $space . "   ");
            $this->printTree($node->right, $space . "   ");
        }


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
            $node->height = max($this->getHeight($node->left),$this->getHeight($node->right)) + 1;
            if ($this->getHeight($node->left) - $this->getHeight($node->right) == 2) {
                $node = $this->leftSigon($node);
            }
        } else if ($value < $node->value) {
            $node->left = $this->delRecursion($node->left, $value);
            $node->height = max($this->getHeight($node->left),$this->getHeight($node->right)) + 1;
            if ($this->getHeight($node->right) - $this->getHeight($node->left) == 2) {
                $node = $this->rightSigon($node);
            }
        } else {
            if ($node->left && $node->right) {
                $tmp = $this->findMin($node->right);
                $node->value = $tmp->value;
                $node->right = $this->delRecursion($node->right, $tmp->value);
                $node->height = max($this->getHeight($node->left),$this->getHeight($node->right)) + 1;
            } else if ($node->left || $node->right) {
                $node = $node->left ? $node->left : $node->right;
                $node->height = max($this->getHeight($node->left),$this->getHeight($node->right)) + 1;
            } else {
                $node = null;
            }

        }

        return $node;
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
}

$node = null;

$arr = [3,2,1,4,5,6,7,16,15,14,13];
//$arr = [6,5,7,4];
//$arr = [6,5,7];
//$arr = [6,7];
$avl = new AvlTree();
foreach ($arr as $val) {
    echo $val . ':::::' . PHP_EOL;
    $node = $avl->insert($val, $node);
   // $avl->printTree($node);
    echo $node->value . ':::::' . PHP_EOL;
    echo "*****************" . PHP_EOL;
}

$avl->printTree($node);
$node = $avl->delRecursion($node,  '7');
$avl->printTree($node);