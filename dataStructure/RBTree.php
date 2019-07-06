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

    /**
     * @var red|black
     */
    public $color = 'b';//颜色

}

/**
 * 红黑树可以联系2-3树，
 * 2结点是普通结点既是黑结点，红结点是3三节点，把一个2-3树分离可以看到是一个红黑树
 * 红黑树特点
 *    性质 1：每个节点要么是红色，要么是黑色，新插入的结点是红色。
性质 2：根节点永远是黑色的。
性质 3：所有的叶节点都是空节点（即 null），并且是黑色的。
性质 4：每个红色节点的两个子节点都是黑色。（从每个叶子到根的路径上不会有两个连续的红色节点）
性质 5：从任一节点到其子树中每个叶子节点的路径都包含相同数量的黑色节点
 *
 *
根据性质 5：红黑树从根节点到每个叶子节点的路径都包含相同数量的黑色节点，因此从根节点到叶子节点的路径中包含的黑色节点数被称为树的“黑色高度（black-height）”。
 *
性质 4 则保证了从根节点到叶子节点的最长路径的长度不会超过任何其他路径的两倍。假如有一棵黑色高度为 3 的红黑树：从根节点到叶节点的最短路径长度是 2，
 * 该路径上全是黑色节点（黑节点 - 黑节点 - 黑节点）。
 * 最长路径也只可能为 4，在每个黑色节点之间插入一个红色节点（黑节点 - 红节点 - 黑节点 - 红节点 - 黑节点），
 * 性质 4 保证绝不可能插入更多的红色节点。由此可见，红黑树中最长路径就是一条红黑交替的路径。
 *
 *
 */

class Tree {
    /**
     * @var Node
     */
    public $root; //定义一个跟结点
    public $nullNode;

    public function __construct()
    {
        $this->nullNode = new Node();
        $this->root = null;
    }

    /**
     * 查找值是否存在于树内
     * @param $value
     * @return string
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
     * 插入操作按如下步骤进行：
    （1）以排序二叉树的方法插入新节点，并将它设为红色。
    （2）进行颜色调换和树旋转。
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
        $node->color = "r";
        $node->parent= $parent;
        if($this->root === null) {
            $node->color = 'b';
            $this->root = $node;
        } else {
            /**
            https://github.com/julycoding/The-Art-Of-Programming-By-July/blob/master/ebook/zh/03.01.md
             * 基于颜色及插入方向判断及进行树的旋转，以保持符合红黑树性质

            换言之

            如果插入的是根结点，因为原树是空树，此情况只会违反性质2，所以直接把此结点涂为黑色。
            如果插入的结点的父结点是黑色，由于此不会违反性质2和性质4，红黑树没有被破坏，所以此时也是什么也不做。
            但当遇到下述3种情况时：

            插入修复情况1：如果当前结点的父结点是红色且祖父结点的另一个子结点（叔叔结点）是红色
            插入修复情况2：当前结点的父结点是红色,叔叔结点是黑色，当前结点是其父结点的右子
            插入修复情况3：当前结点的父结点是红色,叔叔结点是黑色，当前结点是其父结点的左子
             */
            if($fand==1) {
                $parent->left  = $node;
                $this->rbInsert($parent->left);
            } else {
                $parent->right = $node;
                if($value == '6') {
                    echo  "::::::::************::::::::::::::";
                    echo $this->root->left->color;
                    $this->printTree($this->root);
                    echo  "::::::::************::::::::::::::";
                }
                $this->rbInsert($parent->right);
                /*if($value == '3') {
                    echo  "::::::::#::::::::::::::";
                    $this->printTree($this->root);
                    echo  "::::::::########::::::::::::::";
                }*/
            }





        }
    }


    /**
     * @param Node $node
     * @return bool
     */
    public function rbInsert($node) {

        if(!empty($node->parent)) {

            while ($node->parent->color == 'r') {
                /**
                 * 当前结点的父结点是红色且祖父结点的另一个子结点（叔叔结点）是红色。
                 * 当前结点的父节点一定存在，要不它已经不是一颗红黑树（只有黑色结点才会拥有红色结点）
                 * 此种情况不用区分 是左子树还是右子树，他们处理情况是一样的
                 */


                if(!empty($node->parent->parent->right) && !empty($node->parent->parent->left)) {
                    if ($node->parent->parent->right->color == 'r' && $node->parent->parent->left->color == 'r') {

                        $node->parent->parent->color = 'r';
                        if($node->parent->parent->left !== null){
                            $node->parent->parent->left->color = 'b';
                        }

                        if($node->parent->parent->right !== NULL) {
                            $node->parent->parent->right->color = 'b';
                        }
                        if($node->parent->parent->value == $this->root->value) {
                            $this->root = $node->parent->parent;
                        }
                        $this->root->color = 'b';
                        $this->root->parent = null;
                        $node = $node->parent->parent;
                    }
                }

                //当前父节点未祖父结点的左孩子
                if($node->parent->value === $node->parent->parent->left->value) {

                    //如果当前结点是父节点的右节点，及左右模式 （左旋）
                    //以父节点未结点进行左旋
                    /**
                     * 左旋
                     *    当前的结点的右节点变为父节点
                     *    父节点的右结点变为，当前的右节点的左结点
                     *    右节点的左结点未父节点
                     *    祖父结点指向当前结点的右结点
                     */
                    if($node->value == $node->parent->right->value) {
                        //当前结点
                        $current       = $node->parent;
                        //当前结点的右结点
                        $currentRight  = $current->right;
                        //祖父结点
                        $ppNode = $node->parent->parent;

                        //当前结点的右结点的左结点
                        $tmp = $currentRight->left;

                        //当前结点的右节点为右结点的左结点
                        $current->right = $tmp;
                        //右节点变为父节点
                        $current->parent = $currentRight;

                        //祖父指向当前结点的右节点
                        $currentRight->parent = $ppNode;
                        $ppNode->left = $currentRight;

                        //右节点的左结点未当前结点（赋值放到最下边）
                        $currentRight->left = $current;
                        $this->root->color = 'b';
                        $this->root->parent = null;
                        $node = $currentRight->left;

                    } else if($node->value == $node->parent->left->value) {//以祖父为当前结点进行右旋  左左（右旋）
                        /**
                         * 右旋：
                         *    左结点变为当前结点的父节点
                         *    当前结点的变为左结点的右节点
                         *    当前结点的左结点，未左结点的右节点
                         */
                        $node->parent->color = 'b';
                        $node->parent->parent->color = 'r';



                        //祖父节点
                        $current = $node->parent->parent;

                        $currentLeft = $current->left;

                        $tmp = $currentLeft->right;
                        $current->left = $tmp;
                        $tmp->parent = $current;

                        $currentLeft->parent = $current->parent;
                        $current->parent = $currentLeft;
                        //赋值放到最下边
                        $currentLeft->right = $current;

                        if($currentLeft->parent->left->value == $current->value) {
                            $currentLeft->parent->left = $currentLeft;
                        } else if($currentLeft->parent->right->value == $current->value) {
                            $currentLeft->parent->right = $currentLeft;
                        }

                        if($current->value == $this->root->value) {
                            $this->root = $currentLeft;
                        }
                        if($current->value == $this->root->value) {
                            $this->root = $currentLeft;
                        }
                        $this->root->color = 'b';
                        $this->root->parent = null;


                        if($this->root->right->left->color == 'r') {
                            $node = $this->root->right->left;
                        }elseif($this->root->right->right->color == 'r') {
                            $node = $this->root->right->right;
                        } else {
                            break;
                        }

                    }


                } else if($node->parent->value === $node->parent->parent->right->value) { //当前父节点为祖父结点的右孩子 右左 右旋


                    if($node->value == $node->parent->left->value) {

                        //以父节点进行右旋
                        $current = $node->parent;

                        $right = $node->right;


                        $current->left = $right;

                        $ppNode = $node->parent->parent;
                        $node->parent = $ppNode;
                        $ppNode->right = $node;
                        $current->parent = $node;
                        //赋值放到最下边
                        $node->right = $current;
                        $this->root->color = 'b';
                        $this->root->parent = null;
                        $node = $node->right;


                    } else if($node->value == $node->parent->right->value) {//以祖父进行左旋 ,, 右右 -》左旋

                        $current = $node->parent->parent;
                        $current->color = 'r';
                        $node->parent->color = 'b';

                        $currentRight = $node->parent;
                        $tmp = $currentRight->left;
                        $current->right = $tmp;
                        $tmp->parent = $current;

                        $currentRight->parent = $current->parent;
                        $current->parent = $currentRight;

                        $currentRight->left = $current;




                        if($currentRight->parent->left->value == $current->value) {
                            $currentRight->parent->left = $currentRight;
                            echo "LEFT<br>";
                        } else if($currentRight->parent->right->value == $current->value) {
                            $currentRight->parent->right = $currentRight;
                            echo "RIGHT<br>";
                        }

                        if($current->value == $this->root->value) {
                            $this->root = $currentRight;
                        }
                        $this->root->color = 'b';
                        $this->root->parent = null;

                        if($this->root->left->left->color == 'r') {
                            $node = $this->root->left->left;
                        }elseif($this->root->left->right->color == 'r') {
                            $node = $this->root->left->right;
                        } else {
                            break;
                        }



                    }
                }


            }

        }
        $this->root->color = 'b';
        $this->root->parent = null;
        return false;

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
                    break;

                }

                if($link->left === null && $link->right !== null) {
                    if($fand == 1) {
                        $link->parent->left = $link->right;
                    } else {
                        $link->parent->right = $link->right;
                    }
                    break;

                }

                if($link->left !== null && $link->right === null) {
                    if($fand == 1) {
                        $link->parent->left = $link->left;
                    } else {
                        $link->parent->right = $link->left;
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
                    } else {
                        $current->parent->right = $tmp;
                    }
                }
                break;

            }
        }
    }


    /**
     * @param Node $node
     */
    public function printTree($node) {
        if($node !== null) {
            if($node->value == $node->parent->left->value) {
                echo "L";
            } elseif($node->value == $node->parent->right->value) {
                echo "R";
            }
            echo $node->value.":[".$node->parent->value."]:".$node->color."<br>";
            //var_dump($node);
            echo "--------------------------------<br>";
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


    /**
     * @param $node
     * @param $space
     */
    public function printTree2($node, $space = '')
    {
        if ($node) {
            echo $space . $node->value . "[" . $node->color . "]" . PHP_EOL;
            $this->printTree2($node->left, $space . "   ");
            $this->printTree2($node->right, $space . "   ");
        }


    }


}

error_reporting(E_ERROR);

/*$treeNode = [
    1,2,3,4,5,6,7,8
];*/
$treeNode = [
    8,7,6,5,4,3,2,1
];
$arr = [10,85,15,70,20,60,30,50,65,80,90,40,5,55];
$treeModel = new Tree();

foreach ($arr as $val) {
    $treeModel->insert($val);
}



//echo $treeModel->find(8);
//$treeModel->delete(3);
$treeModel->printTree2($treeModel->root);


