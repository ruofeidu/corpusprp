<?php
class ArticleModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		//array('aid','require','请填写作品コード',1),
		//array('semester','require','请填写学期编号',1),
	
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