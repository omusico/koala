<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Helper;
/**
 * 基于改进前序遍历树 的 无限分级类
 *
 * 
 *CREATE TABLE tree (
 * id INT AUTO_INCREMENT PRIMARY KEY,
 * name VARCHAR(20) NOT NULL,
 * lft INT NOT NULL,
 * rgt INT NOT NULL
 *);
 *
 *INSERT INTO tree VALUES
 *(1,'ELECTRONICS',1,20),(2,'TELEVISIONS',2,9),(3,'TUBE',3,4),
 *(4,'LCD',5,6),(5,'PLASMA',7,8),(6,'PORTABLE ELECTRONICS',10,19),
 *(7,'MP3 PLAYERS',11,14),(8,'FLASH',12,13),
 *(9,'CD PLAYERS',15,16),(10,'2 WAY RADIOS',17,18);
 */
class PreorderTreeGrade{
	/**
	 * 数据库操作对象
	 * @var string
	 */
	var $db = null;
	/**
	 * 数据库操作表
	 * @var string
	 */
	var $table = null;
	/**
	 * 够在函数初始化数据源
	 * @param string $table 表名(不含前缀)
	 */
	public function __construct($table='Tree'){
		$this->table = $table;
		$this->db = M($table);
	}
	/**
	 * 获取子树
	 * @param  integer $id 指定根节点
	 * @return array        子树(包含指定根节点)
	 */
	public function getTree($id=0){
		//SELECT lft, rgt FROM tree  WHERE id=$id
		//SELECT * FROM tree WHERE lft BETWEEN 2 AND 11 ORDER BY lft ASC;
		if($id==0){
			//获得子节点
			$trees = $this->db->query("SELECT * FROM $this->table ORDER BY lft ASC");
		}else{
			//获得节点左右值
			$node = $this->db->query("SELECT lft, rgt FROM $this->table  WHERE id=$id")->fetchAll();
			//获得子节点
			$trees = $this->db->query("SELECT * FROM $this->table WHERE lft BETWEEN ".$node[0]['lft']." AND ".$node[0]['rgt']." ORDER BY lft ASC")->fetchAll();
		}
		return $trees;
	}
	/**
	 * 获得子节点到根节点路径节点数组(包括该节点)
	 * @param  integer $id 指定根节点
	 * @return array        节点数组(包含指定根节点)
	 */
	public function getTreePath($id=0){
		//SELECT lft, rgt FROM tree  WHERE id=$id
		$node = $this->db->query("SELECT lft, rgt FROM $this->table  WHERE id=$id")->fetchAll();
		//SELECT name FROM tree WHERE lft < 4 AND rgt > 5 ORDER BY lft ASC;
		//获得子节点
		return $this->db->query("SELECT * FROM $this->table WHERE lft <= ".$node[0]['lft']." AND rgt >= ".$node[0]['rgt']." ORDER BY lft ASC")->fetchAll();
	}
	/**
	 * 获得后续节点数
	 * @param  integer $id 指定根节点
	 * @return integer      节点数
	 */
	public function getChildrenNum($id=0){
		if($id==0){
			$node = $this->db->query("SELECT lft, rgt FROM $this->table ORDER BY lft ASC")->fetchAll();
		}else{
		$node = $this->db->query("SELECT lft, rgt FROM $this->table  WHERE id=$id")->fetchAll();}
		return ($node[0]['rgt']-$node[0]['lft']-1) / 2;
	}
	/**
	 * 处理数据
	 * 增加层级项level字段
	 * @param  array  $data 数据
	 * @return array  数据
	 */
	public function getTreeArray($data=array()){
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
		    // 显示缩进的节点
	    	//echo str_repeat('-',count($right)).$value['id']."<br>";
	    	//组合
	    	$result[] =array_merge(array('level'=>count($right)),$value);
	    	// 把这个节点添加到栈中
	    	$right[] = $value['rgt'];
		}
		return $result;
	  }
	  /**
	   * 从邻接表重建左右值前序遍历树
	   * @param  string $pid  父id
	   * @param  int 	$left 左值
	   * @return int 	$right 右值
	   */
	public function rebuildTreeFromAdjacent($pid, $left){
		// 这个节点的右值是左值加1
    	$right = $left+1; 

    	// 获得这个节点的所有子节点
    	$result = mysql_query('SELECT id FROM tree WHERE pid="'.$pid.'";');
    	while ($row = mysql_fetch_array($result)) {
        	// 对当前节点的每个子节点递归执行这个函数
        	// $right 是当前的右值，它会被rebuildTreeFromAdjacent函数增加
        	$right = rebuildTreeFromAdjacent($row['id'], $right);
    	}

    	// 我们得到了左值，同时现在我们已经处理这个节点我们知道右值的子节点
    	mysql_query('UPDATE tree SET lft='.$left.', rgt='.$right.' WHERE id="'.$pid.'";'); 

    	// 返回该节点的右值+1
    	return $right+1;
	}
	/**
	 * 插入一个节点
	 * @param  integer $id    上级节点
	 * @param  array   $param 当前节点字段参数
	 * @return bool 	结果
	 */
	public function insertNode($id=0,$param=array()){
		//SELECT lft, rgt ,id FROM tree  WHERE id='$id'
		//UPDATE tree SET rgt=rgt+2 WHERE rgt>5;
		//UPDATE tree SET lft=lft+2 WHERE lft>5;
		//INSERT INTO tree SET lft=6, rgt=7, name='Strawberry';
		if($id==0){
			$lft = 0;
			$rgt = 1;
		}else{
			$node = $this->db->query("SELECT lft, rgt ,id FROM $this->table  WHERE id='$id'")->fetchAll();
			$lft = $node[0]['lft'];
			$rgt = $node[0]['rgt'];
		}
		//更新大于上级节点的最后子节点rgt的节点
		$this->db->query("UPDATE $this->table SET rgt=rgt+2 WHERE rgt>=$rgt");
		$this->db->query("UPDATE $this->table SET lft=lft+2 WHERE lft>=$rgt");

		$data['lft'] = $rgt;
		$data['rgt'] = $rgt+1;
		$data =array_merge($data,$param);
		$this->db->create();
		return $this->db->add($data);
	}
	/**
	 * 删除一个节点
	 * @param  integer $id 节点id
	 * @return bool      结果
	 */
	public function deleteNode($id=0){
		if($id==0){
			$node = $this->db->query("SELECT lft, rgt, id FROM $this->table ORDER BY id ASC")->fetchAll();
			$id = $node[0]['id'];
		}else
		$node = $this->db->query("SELECT lft, rgt ,id FROM $this->table  WHERE id=$id")->fetchAll();
		$lft = $node[0]['lft'];
		$rgt = $node[0]['rgt'];
		//是否有孩子节点
		if($this->getChildrenNum($id)>0){
			$this->db->query("UPDATE $this->table SET lft=lft-1, rgt=rgt-1 WHERE lft>$lft AND rgt<$rgt");
		}
		// //更新大于当前节点的最后子节点rgt的节点
		$this->db->query("UPDATE $this->table SET rgt=rgt-2 WHERE rgt>=$rgt");
		$this->db->query("UPDATE $this->table SET lft=lft-2 WHERE lft>=$rgt");

		return $this->db->query("DELETE FROM $this->table WHERE id=$id");
	}
}