<?php
class ErrorAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map){
		$map['uid'] = array('like',"%".$_POST['eid']."%");
	}
}
?>