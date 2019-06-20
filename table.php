<?php
class Node {
	public $next; //指针域
	public $dateType;//数据域
	
}

class Nohead {
	public $head; //头结点
	
	public $size; //当前个数
	
	public function __construct() {
		$this->size = 0;
		$this->head = new Node;
		$this->head->next = $this->head;
		$this->head->dateType = null;
		
	}
	
	//获得节点数
	public function getNum() {
		$p = $this->head;
		$size = 0;
		while(!($p->next === $this->head)) {
			$p = $p->next;
			$size ++;
		}
		return $size;
	}
	
	//插入节点
	public function insert($i,$DateType) {
		
			$p = $this->head;
			$j = -1;
			/*
			判断当前节点存在并且i节点存在的情况下
			  $p->next != null 判断当前节点存在，且i节点存在
			  $j < $i-1判断循环到I-1节点
			循环到要插入元素的位置的前一个元素。*/
			
			while(!($p->next === $this->head) && $j < $i-1) { //循环到要插入元素的位置的前一个元素。
				$p = $p->next;
				$j++;
				
			}
			
			if(!($j === $i-1)) {//此条件判断$p为I-1节点，如果此时I-1为-1则$p 还是头结点
				
				echo "False";
				return false;
			}
			
			$q = new Node;              //新建一个结点
			$q->dateType = $DateType;
			
			$q->next = $p->next;  //把插入当前元素的前一个元素的指向域赋予新建结点
			$p->next = $q;  //把插入当前元素的前一个元素的指向域指向新建结点
			return 1;
			
		
		
	}
	
	
	//删除节点
	public function delete($i) {
		
			$p = $this->head;
			$j = -1;
			while($p->next != null && $j < $i-1) { //循环到要插入元素的位置的前一个元素。
				$p = $p->next;
				$j++;
				
			}
			
			if(!($j === ($i-1))) {
				
				echo "False";
				return false;
			}
			
			
			
			$p->next = $p->next->next;  
			return 1;
			
	}
	
}

echo "<br/><br/>:链式结构<br/>";
$table = new Nohead;
$table->insert(0,1);
//$table->delete(0);
$table->insert(1,2);
$table->insert(2,3);
echo $table->getNum()."<br/>";
 $p = $table->head;
while(!($p->next === $table->head)) {

	$p = $p->next;
	echo $p->dateType."<br/>";
	
}