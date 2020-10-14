<?php
/**
 * 跳跃表
 * Head nodes          Index nodes
 * +-+    right        +-+                      +-+
 * |2|---------------->| |--------------------->| |->null
 * +-+                 +-+                      +-+
 *  | down              |                        |
 *  v                   v                        v
 * +-+            +-+  +-+       +-+            +-+       +-+
 * |1|----------->| |->| |------>| |----------->| |------>| |->null
 * +-+            +-+  +-+       +-+            +-+       +-+
 *  v              |    |         |              |         |
 * Nodes  next     v    v         v              v         v
 * +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+
 * | |->|A|->|B|->|C|->|D|->|E|->|F|->|G|->|H|->|I|->|J|->|K|->null
 * +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+  +-+
 */

class Node
{
    /**
     * @var Node
     */
    public $nextNode; //指向下一个节点

    /**
     * 索引值
     * @var int
     */
    public $score;

    /**
     * @var mixed
     */
    public $data;

    public function __construct($score)
    {
        $this->score = $score;
    }

    public function setData($val)
    {
        $this->data = $val;
    }
}

class IndexNode extends Node
{
    /**
     * @var IndexNode|Node
     */
    public $downNode = null;

    /**
     * @var int 当前的层数
     */
   // public $level = 0;


}


class SkipList
{
    /**
     * 跳跃表层高
     * @var int
     */
    public $level = 1;

    /**
     * 最高层头结点
     * @var IndexNode
     */
    public $head = null;

    CONST SKIPLIST_P = 0.5;
    /**
     * 最大层数
     */
    const MAX_LEVEL  = 16;

    /**
     * SkipList constructor.
     */
    public function __construct()
    {
        $this->head = new IndexNode(null);
    }

    /**
     *
     *理论来讲，一级索引中元素个数应该占原始数据的 50%，二级索引中元素个数占 25%，三级索引12.5% ，一直到最顶层。
     * 因为这里每一层的晋升概率是 50%。对于每一个新插入的节点，都需要调用 randomLevel 生成一个合理的层数。
     *该 randomLevel 方法会随机生成 1~MAX_LEVEL 之间的数，且 ：
     *50%的概率返回 1
     *25%的概率返回 2
     *12.5%的概率返回 3 ...
     *
     */
    public function randomLevel()
    {
        $level = 0;
        while (lcg_value() < self::SKIPLIST_P && $level < self::MAX_LEVEL) {
            $level++;
        }
        return $level;
    }

    /**
     * @param $score
     * @return Node|null
     */
    public function findEntry($score)
    {
        /**
         * @var Node|IndexNode $list
         */
        /**
         * @var Node|IndexNode $list
         */
        $list = $this->head;
        while ($list) {
            while ($list->nextNode && $list->nextNode->score < $score) {
                $list = $list->nextNode;
            }
            if (isset($list->downNode) && !empty($list->downNode)) {
                $list = $list->downNode;
            } else {
                break;
            }
        }
        return $list;
    }

    /**
     * @param $score
     * @return Node|null
     */
    public function findEntry2($score)
    {
        /**
         * @var Node|IndexNode $list
         */
        $list = $this->head;
        while ($list) {
            while ($list->nextNode && $list->nextNode->score < $score) {
                $list = $list->nextNode;
                echo '::'.$list->score.'::'.PHP_EOL;
            }
            if (isset($list->downNode) && !empty($list->downNode)) {
                $list = $list->downNode;
            } else {
                break;
            }
        }
        return $list;

    }

    /**
     * 获取值
     * @param $score
     * @return Node|null
     */
    public function get($score)
    {
        $node = $this->findEntry($score);

        if ($node->nextNode && $node->nextNode->score == $score) {
            return $node->nextNode;
        }
        return null;
    }

    public function addNode($score,$val)
    {
        $node = new Node($score);
        $node->setData($val);

        $entryNode = $this->findEntry($score);
        if ($entryNode && $entryNode->score == $score && $entryNode->data == $val) {
            return;
        }

        $node->nextNode      = $entryNode->nextNode;
        $entryNode->nextNode = $node;

        $head = $down = $this->head;
        /**
         * @var IndexNode|Node $newIndex
         */
        $newIndex = null;
        //因为不是双向链接指定，所以要在当前层，往下一层一层添加 索引节点
        for ($i = $this->level; $i>=1;$i--) {
            while ($down->nextNode && $down->nextNode->score < $score) {
                $down = $down->nextNode;
            }
            if ($down->nextNode && $down->nextNode->score == $score) {
                if ($newIndex) {
                    $newIndex->downNode = $down->nextNode;
                }
                continue;
            } else {
                $upNewIndex = $newIndex ? $newIndex : null;
                $newIndex = new IndexNode($score);
                $newIndex->nextNode = $down->nextNode;
                $down->nextNode = $newIndex;
                if ($upNewIndex) {
                    $upNewIndex->downNode = $newIndex;
                }
            }
            $down = $head->downNode;
            $head = $head->downNode;
        }

        $level = $this->randomLevel();
        //因为层数大于当前层，所以要在当前层，往上一层一层添加 索引节点，并建立索引节点的上下关系
        $up = $this->head;
        for ($i = $this->level+1;$i<= $level;$i++) {
            $downUp       = $up ?? null;
            $up           = new IndexNode(null);
            $newIndex     = new IndexNode($score);
            $up->nextNode = $newIndex;
            if ($downUp) {
                $up->downNode = $downUp;
            }
            while ($downUp->nextNode && $downUp->nextNode->score < $score) {
                $downUp = $downUp->nextNode;
            }
            if ($down->nextNode->score == $score) {
                $newIndex->downNode = $down->nextNode;
                continue;
            }
        }

        $this->head = $up;
        $this->level = $this->level < $level ? $level:$this->level;
    }


    /**
     * 打印跳跃表
     */
    public function prinSkipList()
    {
        $down = $node = $this->head;
        while ($down) {
            $str = '';
            while ($node) {
                $str .= '['.$node->score.']['.(isset($node->downNode) ? $node->downNode->score : null).']['.(isset($node->nextNode) ? $node->nextNode->score : null).']--';
                $node = $node->nextNode;
            }
            echo $str.PHP_EOL;
            $down = $node = $down->downNode;
        }
    }

    /**
     * @param $score
     * @return bool
     */
    public function del($score)
    {
        $node = $this->get($score);
        if (empty($node)) {
            return true;
        }

        $head = $down = $this->head;
        for ($i = $this->level;$i>=1;$i--) {
            $nodeNum = 1;
            $levelNode = $down;
            while ($down->nextNode && $down->nextNode->score < $score) {
                $nodeNum++;
                $down = $down->nextNode;
            }
            if ($down->nextNode && $down->nextNode->score == $score) {
                $down->nextNode = $down->nextNode->nextNode;
                if ($nodeNum <= 2 && !$down->nextNode) {
                    $this->level = $this->level > 1 ? ($this->level - 1) : $this->level;
                    $head = $head->downNode ? $head->downNode : $head;
                }
            }
            $down = $levelNode->downNode ? $levelNode->downNode : $levelNode;
        }
        $this->head = $head;
    }

}

/**
 * Test 1
 */
$skipList = new SkipList();
$skipList->addNode(5,'5');
$skipList->addNode(8,'8');
$skipList->addNode(6,'6');
$skipList->addNode(7,'7');
$skipList->addNode(3,'3');
$skipList->addNode(2,'2');
$skipList->addNode(1,'1');
$skipList->addNode(0,'0');
$skipList->prinSkipList();
echo "-------------------------".PHP_EOL;

/**
 * Test 2
 */
$skipList = new SkipList();
$head2 = new IndexNode(null);
$head1 = new IndexNode(null);

$head2->downNode = $head1;



$data1 = new Node(1);
$data1->setData('1');
$index1 = new IndexNode(1);
$index1->downNode = $data1;

$index2 = new IndexNode(2);
$data2 = new Node(2);
$data2->setData('2');

$index2->downNode = $data2;
$index1->nextNode = $index2;

$data1->nextNode = $data2;


$data3 = new Node(3);
$data3->setData('3');
$data2->nextNode = $data3;

$data4 = new Node(4);
$data4->setData('4');
$data3->nextNode = $data4;


$head1->nextNode = $data1;
$head2->nextNode = $index1;

$head3 = new IndexNode(null);
$head3->downNode = $head2;
$head3->nextNode = new IndexNode(1);
$head3->nextNode->downNode = $index1;

$skipList->head  = $head3;
$skipList->level = 3;
$skipList->prinSkipList();
$skipList->del(1);
echo "-------------------------".PHP_EOL;
$skipList->prinSkipList();
echo "-------------------------".PHP_EOL;
$skipList->addNode(6,'6');
$skipList->prinSkipList();
//$node = $skipList->get(7);
//var_dump($node->score);

