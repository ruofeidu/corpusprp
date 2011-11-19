<?php
class SearchAction extends CommonAction {
	// 前台首页
    public function index(){
		//dump($_SESSION['_ACCESS_LIST']);
		//dump($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null );
        header("Content-Type:text/html; charset=utf-8");
        $article = M('article');
		$articles = $article->select();
		$this->assign("articles", $articles);
		$this->assign("content", "Search:index");
		$this->display("Search:base");
		$this->display();
    }
	
	//浏览作文详细内容
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->error('参数错误');		
		$article = M('article');
		$find = $article->where("id='{$_GET['id']}'")->find();
		
		if ($find['text'] == null) $this->error('此文章不存在');
		$content = $find['text'];
		//echo $data;
		$content = substr($content,strpos($content,"\n"));
		$content = str_replace("\n","<br/>",$content);

		$content = format_text($content);
		
		//	#FFFF6F: yellow
		//if (isset($_GET['keywords'])) {
		//	$content = str_replace($_GET['keywords'], '&nbsp;<b id="tip" style="background-color:#FFFF6F">'.$_GET['keywords'].'</b>', $content);
		//}
		
		$this->assign("a", $find);
		$this->assign("text", $content);
		$this->assign("content", "Search:view");
		$this->display("Search:base");
	}
	
	//搜索
	public function search(){
		if ( !isset($_POST['keywords'])) $this->error('请输入关键字');
		$keywords = $_POST['keywords'];
		$search_type = $_POST['searchtype'];
		$error = $_POST['error']; 
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		$people = $_POST['people'];
		$firstlang = $_POST['firstlang'];
		$year = $_POST['year'];
		
		$article = M('article');
		$student = M('student'); 
		
		$articles = $article->select();
		$find = array(); 
		$result = array(); 
		$n = count($articles);
		
		$list = $article->where("text LIKE '%".$keywords."%'")->select();
		if ($search_type == 'all') {
			$find = $list;
		}else{
			foreach ($list as $l){
				if ($search_type == 'error') {
					//错误文
					if (!isset($error) || $error == 'all')
						if (preg_match('|\[([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*),([^\]\,]*)\]|', $l['text'], $matches)) $find[]=$l;
					else
						if (preg_match('|\[([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*),([^\]\,]*'.$error.'[^\]\,]*)\]|', $l['text'], $matches)) $find[]=$l;
				}
				if ($search_type == 'right') { 
					//修正文
					if (!isset($error) || $error == 'all')
						if (preg_match('|\[([^\]\,]*),([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*)\]|', $l['text'], $matches)) $find[]=$l;
					else
						if (preg_match('|\[([^\]\,]*),([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*'.$error.'[^\]\,]*\]|', $l['text'], $matches)) $find[]=$l;
					
				}
			}
		}
		
		foreach ($find as $item){
			$uid = $item['uid'];
			$aid = $item['aid'];
			$semester = $item['semester'];
			
			$student_info = $student->where("uid='".$uid."'")->find(); 
			
			if ($school != 'all' && $student_info['school'] != $school) continue; 
			if ($gender != 'all' && $student_info['gender'] != $gender) continue; 
			if ($people != 'all' && $student_info['people'] != $people) continue; 
			if ($firstlang != 'all' && $student_info['firstlang'] != $firstlang) continue; 
			if ($year != 'all' && $student_info['year'] != $year) continue; 
			
			$result[] = $item;
		}
		
		foreach ($result as &$item){
			$num = 0;
			$point=0;
			$item['detail']="";
			while ($pos=strpos($item['text'], $keywords, $point)){
				
					$num++;
					$point = $pos+1;
					$sub = my_substr( $item['text'], $pos );
					if ($search_type == 'all' ){
						$item['detail'] .= $num.": ...".format_text( $sub,$keywords )."...<br/>";
					}
					if ($search_type == 'error'){
						if (preg_match('|\[([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*),([^\]\,]*)\]|', $sub, $matches))
							$item['detail'] .= $num.": ...".format_text( $sub,$keywords )."...<br/>";
					}
					if ($search_type == 'right'){
						if (preg_match('|\[([^\]\,]*),([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*)\]|', $sub, $matches))
							$item['detail'] .= $num.": ...".format_text( $sub,$keywords )."...<br/>";
					}
				}	
			
		}

		$this->assign("articles", $result);
		$this->assign("keywords", $keywords); 
		$this->assign("content", "Search:result");
		$this->display("Search:base");
	}
	
	//private 更新文章
	public function update(){
		ini_set('max_execution_time', '1000');
		$article = M('article');
		$articles = $article->select();
		//print_r($articles);
		foreach ($articles as $a){
			$index = $a['semester'].','.$a['aid'].','.$a['uid'];
			$file = "./Public/article/".$index.".txt";
			echo $file;
			
			if (file_exists($file)) {
				echo "file found!";
				$content = file_get_contents($file);
				$text = M("text");
				$find = $text->where("txtid='".$index."'")->find();
				//print_r($find);
				if ($find == null){
					$addr['title'] = $a['title'];
					$addr['txtid'] = $index;
					$addr['text'] = $content;
					$text->add($addr);
				}
			}
		}
		$this->copytext();
	}
}
?>