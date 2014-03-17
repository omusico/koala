<?php
defined('IN_Koala') or exit();
//邮件抽象类
abstract class Base_Mail{
	//云服务对象
    var $object = '';
    /**
     * 设置邮件的附件
     * $attachs = array(
     * 'photo_name'=>'photo二进制数据',
     * )
     * 文件内容支持二进制
     * 
     * @param array $attachs 附件表
     */
    abstract public function setAttachs($attachs = array());
    /**
     * 快速发送邮件
     * 注意该方法返回true意味着成功加入发送队列，但不意味着邮件成功到达
     * @param  string $tomail   收件人
     * @param  string $title    邮件标题
     * @param  string $content  邮件内容
     * @param  string $stmpmail 发件人
     * @param  string $password 密码
     * @param  string $stmp     stmp
     * @param  string $stmpport port
     * @param  bool $tls 是否开启tls(如gmail)
     * @return bool           true/false
     */
    abstract public function quickSend($tomail,$title,$content,$stmpmail,$password,$stmp='',$stmpport=25,$tls=false));
	/**
	 * 清空对象数据
	 * @return bool true/false
	 */
	abstract public function clean();
}
?>