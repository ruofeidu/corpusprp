<?php
class IndexAction extends CommonAction {
	// 后台首页
    public function index(){
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$this->display();
    }
	
	// 前台首页
	public function welcome(){
        header("Content-Type:text/html; charset=utf-8");
        $article = M('article');
		$articles = $article->select();
		
		$this->assign("articles", $articles);
		$this->assign("content", "Index:index");
		$this->display("Public:base");
		
		$this->display();
    }
	
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->error('参数错误');		
		$article = M('article');
		$find = $article->where("id='{$_GET['id']}'")->find();
		
		if ($find['text'] == null) $this->error('此文章不存在');
		$content = $find['text'];
		//echo $data;
		$content = str_replace("\n","<br/>",$content);

		$content = format_text($content);
		
		//	#FFFF6F: yellow
		//if (isset($_GET['keywords'])) {
		//	$content = str_replace($_GET['keywords'], '&nbsp;<b id="tip" style="background-color:#FFFF6F">'.$_GET['keywords'].'</b>', $content);
		//}
		
		$this->assign("a", $find);
		$this->assign("text", $content);
		$this->assign("content", "Index:view");
		$this->display("Public:base");
	}
	
	public function array_insert($myarray, $value, $position = 0)
	{
		$fore = ($position == 0) ? array() : array_splice($myarray,0,$position);
		$fore[] = $value;
		$ret = array_merge($fore,$myarray);
		return $ret;
	}
	
	/**
	public function search(){
		if ( !isset($_POST['keywords']) ) $this->redirect('Index/index', array(), 2, '参数错误');
        header("Content-Type:text/html; charset=utf-8");
		
		$keywords = $_POST['keywords'];
		$article = M('article');
		$text = M("text");
		$student = M('student');
		
		$articles = $article->select();
		$students = $student->select(); 
		$result = array(); 
		$n = count($articles);
		
		$search_type = $_POST['searchtype'];
		$error = $_POST['error']; 
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		$people = $_POST['people'];
		$year = $_POST['year'];
		
		if ($search_type == "all") {
			for ($i = 0; $i < $n; $i++)
			{
				$str = ($articles[$i]['semester']) .','. ($articles[$i]['aid']) .','. ($articles[$i]['uid']);

				$find = $text->where("txtid='".$str."'")->limit(1)->find();
				if ($find == null) continue; 
				
				$content = $find['text'];
				$ok = false; 
				if (strpos($content, $keywords)) {
					array_push($result, $articles[$i]);
				}
			}
		} else if ($search_type == "error"){
			for ($i = 0; $i < $n; $i++)
			{
				$str = ($articles[$i]['semester']) .','. ($articles[$i]['aid']) .','. ($articles[$i]['uid']);

				$find = $text->where("txtid='".$str."'")->limit(1)->find();
				if ($find == null) continue; 
				
				$content = $find['text'];
				$ok = false; 
				if (ereg('\[([^\]\,]*' . $keywords . '*),([^\]\,]*),([^\]\,]*)\]', $content)) {
					array_push($result, $articles[$i]);
				}
			}
		} else {
		
		}
		$this->assign("articles", $result);
		$this->assign("keywords", $keywords); 
		$this->assign("content", "Index:search");
		$this->display("Public:base");
	} 
	**/
	
	//下面是SQL查询，但是——strpos比SQL速度快2s啊！！
	
	public function search(){
		if ( !isset($_POST['keywords']) || $_POST['keywords']=="" ) $this->error('请输入关键字');
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
			//错误文
			if ($search_type == 'error') {
				foreach ($list as $l){
					if (preg_match('|\[([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*),([^\]\,]*)\]|', $l['text'], $matches))
						$find[]=$l;
				}
			} else { //修正文
				foreach ($list as $l){
					if (preg_match('|\[([^\]\,]*),([^\]\,]*'.$keywords.'[^\]\,]*),([^\]\,]*)\]|', $l['text'], $matches))
						$find[]=$l;
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
				$item['detail'] .= $num.": ...".format_text( my_substr( $item['text'], $pos ),$keywords )."...<br/>";
				
			}
		}

		$this->assign("articles", $result);
		$this->assign("keywords", $keywords); 
		$this->assign("content", "Index:search");
		$this->display("Public:base");
	}
	
	
	//For fun~
	public function checkKeyword() { 
        if (!empty($_POST['keywords'])) { 
			$this->success('搜索字段大于1!'); 
        }else{ 
            $this->error('搜索字段为空！'); 
        } 
    } 

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