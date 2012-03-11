<?php
class ArticleAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map){
		$map['aid'] = array('like',"%".$_POST['name']."%");
	}
}
?>