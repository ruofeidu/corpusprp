<?php
class ArticleModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('aid','require','文章id要填写哦~',1),
		array('semester','require','学期要填写哦~',1),
	
		array('title','require','标题要填写哦~',1),
		array('text','require','文章内容要填写哦~'),
		
		array('aid','','编辑成功', 0, 'unique', self::MODEL_INSERT),
		);
	// 自动填充设置
	protected $_auto	 =	 array(
		array('status','1',self::MODEL_INSERT),
		array('create_time','time',self::MODEL_INSERT,'function'),
		);

}
?>