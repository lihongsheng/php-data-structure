<?php
/**
 * importal_contract_hospitals.php
 * 导入第三方医院
 * 作者: 李红生 (dannyzml@qq.com)
 * 创建日期: 16/11/20 下午12:47
 * 修改记录:
 *
 * $Id$
 */

include_once(__DIR__.'/../indexc.php');

$hosArray = [
    /*[
        'chHid'       => '96YiL1wk4Mt',
        'chTypeValue' => 'WEIYI',
        'chSource'    => '908c2c6f-41b7-477b-b7a4-3c100189b5ce000',
        'chName'      => '黑龙江省医院',
    ],
    [
        'chHid'       => 'cqbN7K9XFqR',
        'chTypeValue' => 'WEIYI',
        'chSource'    => '9866fb92-c720-11e1-913c-5cf9dd2e7135000',
        'chName'      => '焦作市第二人民医院',
    ],*/
    [
        'chHid'       => 'OG8Zq8iv6M',
        'chTypeValue' => 'WEIYI',
        'chSource'    => '125358368239002000',
        'chName'      => '复旦大学附属肿瘤医院',
    ],
];

$model = new ContractHospitalsModel();
foreach($hosArray as $val) {
    $model->setDatas($val);
    $model->getId();
    $model->add();
}


$model = new HospitalsMapModel();

$hosMap = [
    /*[
        'hmType'      =>$model::PORTAL_COMPANY,
        'hmTypeValue' => 'WEIYI',
        'hmSource'    => '908c2c6f-41b7-477b-b7a4-3c100189b5ce000',
        'hmHid'       => '96YiL1wk4Mt',
        'hmModules'   => $model::COMPANY_MODULE_TICKETS.','.$model::COMPANY_MODULE_CONSULT,
        'hmName'      => '黑龙江省医院',
        'hmSort'      => 0,
    ],
    [
        'hmType'      =>$model::PORTAL_COMPANY,
        'hmTypeValue' => 'WEIYI',
        'hmSource'    => '9866fb92-c720-11e1-913c-5cf9dd2e7135000',
        'hmHid'       => 'cqbN7K9XFqR',
        'hmModules'   => $model::COMPANY_MODULE_TICKETS.','.$model::COMPANY_MODULE_CONSULT,
        'hmName'      => '焦作市第二人民医院',
        'hmSort'      => 0,
    ],*/
    [
        'hmType'      =>$model::PORTAL_COMPANY,
        'hmTypeValue' => 'WEIYI',
        'hmSource'    => '125358368239002000',
        'hmHid'       => 'cqbN7K9XFqR',
        'hmModules'   => $model::COMPANY_MODULE_TICKETS.','.$model::COMPANY_MODULE_CONSULT,
        'hmName'      => '复旦大学附属肿瘤医院',
        'hmSort'      => 0,
    ],
];
foreach($hosMap as $val) {
    $model->setDatas($val);
    $model->getId();
    $model->add();
}










exit(strtolower('koL6GAfbIVl'));


$ads = [
	 0 => [
	 	'appid'       => 'wxec941f8da020fe9e',
	 ],
];


$userData = [];


function AdsGetAppid($ads, $userData, $appid = 'wxsdfsdfsdfsd', $isSubscribe = 1,$uid = 0,$wid = 0) {
        //把默认的微信压入广告数据头部
        array_unshift($ads, ['appid' => $appid, 'isSubscribe' => $isSubscribe]);
        //$appidLogin = self::getUidAppidWid($uid,$appid,$wid);
        $appidLogin   = 0;
        //设置 默认的
        $userData[$appid] = [
            'isSubscribe'   => $isSubscribe,
            'loginTotal'    => $appidLogin,
        ];
        //把需要关注的微信appid 按照广告顺序选择出来
        $wxList = [];
        $length   = count($ads);
        for ($i = 0; $i < $length; $i++) {
            if($userData[$ads[$i]['appid']]['isSubscribe'] == 1) {
                continue;
            }

            $wxList[] = [
                'appid'      => $ads[$i]['appid'],
                'loginTotal' => $userData[$ads[$i]['appid']]['loginTotal'],
            ];
        }



        $nFindIndex = -1;          //最小的数组索引标记
        $nFindLoginCount = -1;     //用于冒泡 表次数
        $nFindMaxNum     = -1;
        //从里面选择登陆次数最小的，让对方关注
        $length   = count($wxList);

        for ($i = 0; $i < $length; $i++) {
            //当前的登录的次数
            $LoginCount = $wxList[$i]['loginTotal'];
            if (($nFindLoginCount == -1) || ($nFindLoginCount > $LoginCount)){
                $nFindLoginCount = $LoginCount;
                $nFindIndex = $i;
             }
            //找到最大登录数
            if(($nFindMaxNum == -1) || ($nFindMaxNum < $LoginCount)) {
                $nFindMaxNum = $LoginCount;
            }
        }

        if ($nFindIndex != -1){
           $tmpAppid = $wxList[$nFindIndex]['appid'];
            if($appid == $tmpAppid) {
                self::setUidAppidWid($uid,$appid,$wid,$nFindMaxNum+1);
            }
            return $tmpAppid;
        }

        return '';
    }

echo AdsGetAppid($ads,$userData);
exit;


/*
menu





http://tv.leyue100.com:8080/appkweb/YiVoeJUbMh9z/basic_model_02/?uid=m_45672c83844dea335e2a9a31ea8f44df&wid=4QoubAb0964&position_id=s0001&dop_origin_sp=LEYUE&dop_origin_id=m_45672c83844dea335e2a9a31ea8f44df&dop_origin_key=e0323d363ec638469222d371da5a5394153603b9900f8f646a9e31b7a71340c8f71608a81241d960bd2f058eb884753f4f9629e2a294790c0daf12586f9687820ea68671ba5b65e5a9a032dbb0ddae883e3cd9742e7f75b61de64bd20acebe0a6d6d730b8db914569c363ae6cb964a5e9372ebf9c8c5208b5c0a9c61bbaf857e520dbb58afcd308537592745399a44aac0c9deee904d8f141bd8c4d8291bc2bd1e821b023a81dbf23e06529a07a09a7e38383025ebaa033b53e0e5526031e2cd8482b4d606ad730f91d8a77fbd16c570e08f1fbabfa65251539b18333c32747e79a98020717fefb81a4134c3a42149d3


//获取Appid
function  getAppid($ads, $userData, $appid, $isSubscribe) {
	array_unshift($ads, ['appid' => $appid, 'isSubscribe' => $isSubscribe]);
	$userData[$appid] = [
		'isSubscribe'   => $isSubscribe,
		'loginTotal'    => 0,
	];
    //把需要关注的微信appid 按照广告顺序选择出来
    $wxList = [];
    $length   = count($ads);
    for ($i = 0; $i < $length; $i++) {
        if($userData[$ads[i]['appid']]['isSubscribe'] == 1) {
            continue;
        }

        $wxList[] = [
            'appid'      => $ads[i]['appid'],
            'loginTotal' => $userData[$ads[i]['appid']]['loginTotal'];
        ];
    }

    $nFindIndex = -1;
    $nFindLoginCount = -1;
    //从里面选择登陆次数最小的，让对方关注
    $length   = count($wxList);
    
    for ($i = 0; $i < $length; $i++) {
        $LoginCount = wxList[i]['loginTotal'];
        if (($nFindLoginCount == -1) || ($nFindLoginCount > $LoginCount)){
            $nFindLoginCount = $LoginCount;
            $nFindIndex = $i;
        }
    }

    if ($nFindIndex != -1){
        return wxList[$nFindIndex]['appid'];
    }

    return '';
}



function  getAppid($ads,$userData) {
	$tmp = [];
	 //用户数据为空，按照广告返回
	 if(empty($userData)) {
	 	return $ads[0]['appid'];
	 }

	 $tmpUserData = $userData;

	 foreach ($userData as $key => $value) {
	 	$userData[$key]['appid'] = $key;
	 }
	 $userData = array_values($userData);
	 $length   = count($userData);
	//按照启动次数排序
    for ($i = 0; $i < $length; $i++) {
        for($j = $i+1; $j < $length;$j++) {
                if($userData[$i]['loginTotal'] > $userData[$j]['loginTotal']) {
                    $_tmp = $userData[$i];
                    $userData[$i] = $userData[$j];
                    $userData[$j] = $_tmp;
                }
        }
    }
    
    //去除用户中已经关注的数据
    for ($i = 0; $i < $length; $i++) {
    	if($userData[$i]['isSubscribe'] == 1) {
    		continue;
    	}
    	$tmp[] = [
    		'appid'      => $userData['appid'],
    		'loginTotal' => $userData['loginTotal']
    	];
    }

    //把广告数据压入临时数组$tmp 未关注的appid集合
    while ($tmpAds = array_pop($ads)) {
    	if($tmpAds['isSubscribe'] == 1 || isset($tmpUserData[$tmpADs['appid']])) {
    		continue;
    	}
    	$_tmp = [
    		'appid'       => $tmpADs['appid'],
    		'loginTotal'  => 0
    	];
    	//在临时数组$tmp头部压入
    	array_unshift($tmp, $_tmp);
    }

    unset($tmpUserData,$userData,$tmpAds);

    if(!empty($tmp)) {
    	$appid = array_shift($tmp);
    	return $appid['appid'];
    }
    return '';
}







//定义结点

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
			$j = -1;*/
			/*
			判断当前节点存在并且i节点存在的情况下
			  $p->next != null 判断当前节点存在，且i节点存在
			  $j < $i-1判断循环到I-1节点
			循环到要插入元素的位置的前一个元素。
			
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
	
}*/