<?php
defined('IN_KOALA') or exit();
/**
 * 预排序树无限分级类
 */
class Helper_PreorderTreeGrade{
	//数据库操作对象
	var $db = null;
	public function __construct($table='Tree'){
		$this->db = M($table);
	}
	//获得子树
	public function getTree($tid=1){
		//SELECT lft, rgt FROM tree  WHERE tid=$tid
		//SELECT * FROM tree WHERE lft BETWEEN 2 AND 11 ORDER BY lft ASC;
		if($tid==0){
			//获得子节点
			$tree = $this->db->query("SELECT * FROM __TABLE__ ORDER BY lft ASC");
		}else{
			//获得节点左右值
			$node = $this->db->query("SELECT lft, rgt FROM __TABLE__  WHERE tid=$tid");
			$lft = $node[0]['lft'];
			$rgt = $node[0]['rgt'];
			//获得子节点
			$tree = $this->db->query("SELECT * FROM __TABLE__ WHERE lft BETWEEN $lft AND $rgt ORDER BY lft ASC");
		}
		return $tree;
	}
	//获得子节点到根节点路径节点数组(包括该节点)
	public function getTreePath($tid=1){
		//SELECT lft, rgt FROM tree  WHERE tid=$tid
		$node = $this->db->query("SELECT lft, rgt FROM __TABLE__  WHERE tid=$tid");
		$lft = $node[0]['lft'];
		$rgt = $node[0]['rgt'];
		//SELECT name FROM tree WHERE lft < 4 AND rgt > 5 ORDER BY lft ASC;
		//获得子节点
		$tree = $this->db->query("SELECT * FROM __TABLE__ WHERE lft <= $lft AND rgt >= $rgt ORDER BY lft ASC");
		return $tree;
	}
	//获得后续节点数
	public function getChildrenNum($tid=1){
		$node = $this->db->query("SELECT lft, rgt FROM __TABLE__  WHERE tid=$tid");
		$lft = $node[0]['lft'];
		$rgt = $node[0]['rgt'];
		return ($rgt-$lft-1) / 2;
	}
	//处理数据增加层级项字段值
	public function getTreeArray($data=array()) {
		// 以一个空的$right栈开始
    	$right = array(); 
		foreach ($data as $key => $value) {
			// 检查栈里面有没有元素
		    if (count($right)>0) {
		      // 检查我们是否需要从栈中删除一个节点
		      while (!empty($right)&&$right[count($right)-1]<$value['rgt']) {
		        array_pop($right);
		      }
		    }
		    // 显示缩进的节点标题
	    	//echo str_repeat('  ',count($right)).$value['name']."\n";
	    	//组合
	    	$result[] =array_merge(array('level'=>count($right)),$value);
	    	// 把这个节点添加到栈中
	    	$right[] = $value['rgt'];
		}
		return $result;
	  }

	//从邻接表重建左右值前序遍历树
	//需要一个指明父节点的字段//TODO
	public function rebuildTreeFromAdjacent($parent, $left){
		// 这个节点的右值是左值加1
    	$right = $left+1; 

    	// 获得这个节点的所有子节点
    	$result = mysql_query('SELECT name FROM tree '.
                           'WHERE parent="'.$parent.'";');
    	while ($row = mysql_fetch_array($result)) {
        	// 对当前节点的每个子节点递归执行这个函数
        	// $right 是当前的右值，它会被rebuild_tree函数增加
        	$right = rebuild_tree($row['name'], $right);
    	} 

    	// 我们得到了左值，同时现在我们已经处理这个节点我们知道右值的子节点
    	mysql_query('UPDATE tree SET lft='.$left.', rgt='.
                 $right.' WHERE name="'.$parent.'";'); 

    	// 返回该节点的右值+1
    	return $right+1;
	}
	//插入一个节点
	public function insertNode($tid=1,$param=array()){
		if($tid==0){
			$lft = 0;
			$rgt = 1;
		}else{
			$node = $this->db->query("SELECT lft, rgt ,tid FROM __TABLE__  WHERE tid='$tid'");
			$lft = $node[0]['lft'];
			$rgt = $node[0]['rgt'];
		}
		$this->db->execute("UPDATE __TABLE__ SET rgt=rgt+2 WHERE rgt>$rgt-1");
		$this->db->execute("UPDATE __TABLE__ SET lft=lft+2 WHERE lft>$rgt-1");

		$data['lft'] = $rgt;
		$data['rgt'] = $rgt+1;
		$data =array_merge($data,$param);
		$this->db->create();
		return $this->db->add($data);
		//UPDATE tree SET rgt=rgt+2 WHERE rgt>5;
		//UPDATE tree SET lft=lft+2 WHERE lft>5;
		//INSERT INTO tree SET lft=6, rgt=7, name='Strawberry';
	}
	//删除一个节点
	public function deleteNode($tid=1){
		$node = $this->db->query("SELECT lft, rgt ,tid FROM __TABLE__  WHERE tid=$tid");
		$lft = $node[0]['lft'];
		$rgt = $node[0]['rgt'];
		//是否有孩子节点
		if($this->getChildrenNum($tid)>0){
			$this->db->execute("UPDATE __TABLE__ SET lft=lft-1, rgt=rgt-1 WHERE lft>$lft AND rgt<$rgt");
		}

		$this->db->execute("UPDATE __TABLE__ SET rgt=rgt-2 WHERE rgt>$rgt");
		$this->db->execute("UPDATE __TABLE__ SET lft=lft-2 WHERE lft>$lft");
		return $this->db->execute("DELETE FROM __TABLE__ WHERE lft='$lft' AND rgt=$rgt");
	}
}
/*
CREATE TABLE tree (
 category_tid INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(20) NOT NULL,
 lft INT NOT NULL,
 rgt INT NOT NULL
);
INSERT INTO tree
VALUES(1,'ELECTRONICS',1,20),(2,'TELEVISIONS',2,9),(3,'TUBE',3,4),
(4,'LCD',5,6),(5,'PLASMA',7,8),(6,'PORTABLE ELECTRONICS',10,19),
(7,'MP3 PLAYERS',11,14),(8,'FLASH',12,13),
(9,'CD PLAYERS',15,16),(10,'2 WAY RADIOS',17,18);
 */
?>