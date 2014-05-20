<?php
defined('IN_KOALA') or exit();
/**
 * 邻接分级类//TODO
 * 
 */
class Helper_AdjacentGrade{
	//数据操作对象
	var $db;
	public function __construct(){
		$this->db=M('category');
	}
	/**
	 * 获得到指定栏目的路径
	 * @param  int $category_id 栏目id
	 * @return array            路径数组
	 */
	public function getPath($category_id){
	// 查找当前节点的父节点的ID，这里使用表自身与自身连接实现
    $sql = "
        SELECT c1.parent_id, c2.category_name AS parent_name 
        FROM category AS c1
 
        LEFT JOIN category AS c2 
        ON c1.parent_id=c2.category_id 
 
        WHERE c1.category_id='$category_id' ";
    $row = $this->db->query($sql);
	//现在$row数组存了父亲节点的ID和名称信息
	//将树状路径保存在数组里面
    $path = array();
	//如果父亲节点不为空（根节点），就把父节点加到路径里面
    if ($row['parent_id']!=NULL){
	    //将父节点信息存入一个数组元素
	    $parent[0]['category_id'] = $row['parent_id'];
	    $parent[0]['category_name'] = $row['parent_name'];
	    //递归的将父节点加到路径中
	    $path = array_merge($this->getPath($row['parent_id']), $parent);
	    }
    return $path;
	}
	public function display_children($category_id, $level) {
		//TODO;
		exit;
		$con = mysql_connect("localhost","root","123456");
		if (!$con) {
		die('数据库连接失败: ' . mysql_error());
		}

		mysql_select_db('test', $con); 

		// 获得当前节点的所有孩子节点（直接孩子，没有孙子）
		$result = mysql_query("SELECT * FROM category WHERE parent_id='$category_id'");


		// 遍历孩子节点，打印节点
		while ($row = mysql_fetch_array($result)) 
		{
		// 根据层级，按照缩进格式打印节点的名字
		// 这里只是打印，你可以将以下代码改成其他，比如把节点信息存储起来
		echo str_repeat('--',$level) . $row['category_name'] . "<br/>";
		// 递归的打印所有的孩子节点
		display_children($row['category_id'], $level+1);
		}
	}
}
/*

-- --------------------------------------------------------
 
--
-- 表的结构 `category`
--
 
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;
 
--
-- 转存表中的数据 `category`
--
 
INSERT INTO `category` (`category_id`, `category_name`, `parent_id`) VALUES
(1, 'A', NULL),
(2, 'B', 1),
(3, 'C', 1),
(4, 'D', 1),
(5, 'E', 2),
(6, 'F', 2),
(7, 'I', 4),
(8, 'G', 5),
(9, 'H', 5),
(10, 'J', 7),
(11, 'K', 10),
(12, 'L', 10);
 */
?>