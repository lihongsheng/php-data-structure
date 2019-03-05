<?php
/**
 * Tree.php
 *
 * 作者: lihongsheng (******@qq.com)
 * 创建日期: 17/7/21 下午10:45
 * 修改记录:
 *
 * $Id$
 */

/**
 * 定义一个树结点结构
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

    /**
     * @var Node
     */

    public $parent = null; //父节点

}


class Tree {
    /**
     * @var Node
     */
    public $root; //定义一个跟结点

    public function __construct()
    {
        $this->root = null;
    }

    /**
     * 查找值是否存在于树内
     * @param $value
     */
    public function find($value) {
        return $this->__find($value,$this->root);
    }

    public function __find($value,$node) {
        if($node === null) {
            return false;
        }

        if($node->value > $value) {
            $this->__find($value,$node->left);
        } elseif ($node->value < $value) {
            $this->__find($value,$node->right);
        }else {
            return $value;
        }
    }


    /**
     *
     */
    public function insert($value) {
        $link = $this->root;
        $parent = null;
        $fand = null;
        while ($link!== null) {
            $parent = $link;
            if($value < $link->value) {
                $fand = 1;
                $link = $link->left;
            }elseif($value > $link->value) {
                $fand = 2;
                $link = $link->right;
            } else {
                return true;
            }
        }
        $node = new Node();
        $node->value = $value;
        $node->left  = null;
        $node->right = null;
        $node->parent= $parent;
        if($this->root === null) {
            $this->root = $node;
        } else {
            if($fand==1) {
                $parent->left = &$node;
            } else {

                $parent->right = &$node;
            }

        }
    }



    public function delete($value) {
        $link = $this->root;
        $parent = null;
        $fand = false;
        while ($link!== null) {
            if($value < $link->value) {
                $fand = 1;
                $link = $link->left;
            }elseif($value > $link->value) {
                $fand = 2;
                $link = $link->right;
            } else {

                if($link->left === null && $link->right === null) {
                    $link == null;
                    if($fand == 1) {
                        $link->parent->left = null;
                    } else {
                        $link->parent->right = null;
                    }
                    break;

                }

                if($link->left === null && $link->right !== null) {
                    if($fand == 1) {
                        $link->parent->left = $link->right;
                        $link->right->parent = $link->parent;
                    } else {
                        $link->parent->right = $link->right;
                        $link->right->parent = $link->parent;
                    }
                    break;

                }

                if($link->left !== null && $link->right === null) {
                    if($fand == 1) {
                        $link->parent->left = $link->left;
                        $link->left->parent = $link->parent;
                    } else {
                        $link->parent->right = $link->left;
                        $link->left->parent = $link->parent;
                    }

                    break;
                }

                if($link->left !== null && $link->right !== null) {
                    $current = $link;
                    $tmp = $link->right;
                    while ($tmp->left !== null) {
                        $tmp = $tmp->left;
                    }
                    $tmp->left =$link->left;
                    $tmp->right=$link->right;
                    if($tmp->value == $link->right->value) {
                        $tmp->right = null;
                    }
                    if($fand==1) {
                        
                        $current->parent->left  = $tmp;
                        $tmp->parent = $current->parent;
                    } else {
                        $current->parent->right = $tmp;
                    
                        $tmp->parent = $current->parent;
                    }
                }
                break;

            }
        }
    }

    /**
     * 范围查找
     * @param $value
     * @param $endValue
     * @param $node
     * @return array
     */
    public function findBy($value,$endValue,$node) {
        static $tmp = [];

        if($node !== null) {

            if($value <= $node->value && $endValue>=$node->value) {
                $tmp[$node->value] = $node->value;
            }

            if ($value < $node->value) {
                $this->findBy($value, $endValue, $node->left);
                echo $node->value."..<br/>";
            }elseif($endValue>$node->value){
                echo $node->value.";;<br/>";
                $this->findBy($value, $endValue, $node->right);

            }

        }
        return $tmp;
    }



    public function printTree($node) {
        if($node !== null) {
            echo $node->value."<br>";
            $this->printTree($node->left);
            $this->printTree($node->right);

            /**
            中序遍历
            $this->printTree($node->left);
            echo $node->value."<br>";
            $this->printTree($node->right);
             **/

        }
    }


    public function print2Tree($node,$n) {
        $i = 0;
        if($node == NULL) return;
        $this->print2Tree($node->right,$n+1);
        for ($i = 0; $i < $n-1; ++$i)
        {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
        }

        echo "----";
        echo  $node->value."<br/>";

        $this->print2Tree($node->left,$n);
    }

}


$treeNode = [
    8,7,3,0,5,23,12,14,16,18,19,30,20,47
];

$treeModel = new Tree();

foreach ($treeNode as $val) {
    $treeModel->insert($val);
}

echo $treeModel->find(8);
$treeModel->delete(3);
$treeModel->printTree($treeModel->root);
$treeModel->print2Tree($treeModel->root,0);

echo var_dump($treeModel->root);


/*var_dump($treeModel->findBy(12,20,$treeModel->root));
var_dump($treeModel->root);*/
