<?php
class ErrorModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		//array('eid','require','请填写附码コード',1),
		//array('type','require','请填写附码类型',1),
	
		//array('title','require','请填写題目',1),
		//array('text','require','请填写文章内容',1),
	
		//array('id','','ID已经存在', 0, 'unique', self::MODEL_INSERT)
	);
	
	// 自动填充设置
	protected $_auto	 =	 array(
		//array('status','1',self::MODEL_INSERT),
		//array('create_time','time',self::MODEL_INSERT,'function'),
	);

}
?>