<?php
class SearchAction extends CommonAction {
	// 前台首页
    public function index(){
		//dump($_SESSION['_ACCESS_LIST']);
		//dump($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null );
		//dump($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN']);
		
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null){
			$admin_user = true; 
		} else {
			$admin_user = false; 
		}
		
        header("Content-Type:text/html; charset=utf-8");
        $article = M('article');
		$articles = $article->select();
		$this->assign("hasResult", -1); 
		$this->assign("articles", $articles);
		$this->assign("admin_user", $admin_user);
		$this->assign("content", "Search:index");
		$this->display("Search:base");
		$this->display();
    }
	public function viewpic(){
		$i = 1; 
		$a = array(); 
		$txtid = $_GET['txtid'];
		
		do {
			$fileName = './Public/Photo/'. $txtid .'/000'.$i.'.jpg';
			if (file_exists($fileName)) {
			} else {
				break; 
			}
			$fileName = '000' . $i . '.jpg'; 
			array_push($a, $fileName); 
			++$i; 
			
		} while (true); 
		
		if ($i == 1) echo "对不起，该作文目前没有参考扫描件"; 
		$this->assign("txtid", $txtid); 
		$this->assign("picture", $a); 
		$this->display();
	}
	//浏览作文详细内容
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->error('参数错误');		
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null){ $admin_user = true; } else { $admin_user = false;  }
		$this->assign("admin_user", $admin_user);
		
		$article = M('article');
		$find = $article->where("id='{$_GET['id']}'")->find();
		
		if ($find['text'] == null) $this->error('此文章不存在');
		$content = $find['text'];
		//echo $data;
		$content = substr($content,strpos($content,"\n"));
		$content = str_replace("\n","<br/>",$content);

		if (!isset($_GET['error'])) $error="";
		else $error=$_GET['error'];
		$content = format_text($content,$_GET['keywords'], $_GET['error']);
		
		//	#FFFF6F: yellow
		//if (isset($_GET['keywords'])) {
		//	$content = str_replace($_GET['keywords'], '&nbsp;<b id="tip" style="background-color:#FFFF6F">'.$_GET['keywords'].'</b>', $content);
		//}
		$this->assign("a", $find);
		$this->assign("text", $content);
		$this->assign("content", "Search:view");
		$this->display("Search:viewbase");
	}
	
	public function exportCSV($name, $title, $array){
	//内容的类型
		header("Content-Type:text/plain; charset=utf-8");    
	// 以附件形式保存  $name 默认保存时的文件名 
		header("Content-Disposition:attachment;filename=$name"); 
	// 不缓存
		header("Pragma:no-cache");     
	// 浏览器不缓存的时间 
		header("Expires:0"); 

		//iconv("utf-8", "ansi", $name);   
		//iconv("utf-8", "ansi", $array);   
		echo "\xEF\xBB\xBF";
		
	// 循环输出 excel 抬头
		foreach($title as $value){ // excel抬头
			echo '"'.$value.'",';
			//echo '"'.iconv("utf-8", "gb2312", $value).'",';
		}
		echo "\r\n"; // 换行
	// 循环输出 excel 内容
		foreach($array as $val){
			foreach($val as $v){
				echo '"'.$v.'",';
				//echo '"'.iconv("utf-8", "gb2312",$v).'",';
		}
		echo "\r\n"; // 换行
		}
	}
	
	//搜索
	public function search(){
		if ( (!isset($_POST['keywords'])||$_POST['keywords']==""||$_POST['keywords']=='ss'||strlen($_POST['keywords'])<2) && (!isset($_POST['error'])||$_POST['error']=="") ) {
			//管理员允许拖库，调试方便
			if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] == null) {
				if (strlen($_POST['keywords'])<2 || $_POST['keywords']=='ss'){
					echo '<b style="color:red;">请输入正确的关键词</b>';
					exit();
				}
			}
		}
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null){ $admin_user = true; } else { $admin_user = false;  }
		$this->assign("admin_user", $admin_user);
		
		$keywords = $_POST['keywords'];
		if (!isset($_POST['error'])) $error="";	else $error = $_POST['error']; 
		if (isset($_POST['page'])) $page = $_POST['page']; else $page = 1;
		if (isset($_POST['listnum'])) $listnum = $_POST['listnum']; else $listnum = 30;
		if (isset($_POST['download'])) $download = $_POST['download']; else $download = 0;
		//echo $keywords.":".$error;
		
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		//$studytime = $_POST['studytime'];
		$firstlang = $_POST['firstlang'];
		$semester = $_POST['year'];
		$uid = $_POST['uid'];
		
		$timemin = $_POST['timemin'];
		$timemax = $_POST['timemax'];
		
		$condition = "";
		//if ($school!="") $condition .="corpus_student.school='$school' AND ";
		if ($school!="") $condition .="corpus_article.aid LIKE '$school%' AND ";
		if ($gender!="") $condition .="corpus_student.gender='$gender' AND ";
		//if ($studytime!="") $condition .="corpus_student.studytime='$studytime' AND ";
		if ($firstlang!="") $condition .="corpus_student.firstlang='$firstlang' AND ";
		if ($semester!="") $condition .="corpus_article.semester='$semester' AND ";
		if ($uid!="") $condition .="corpus_article.uid='$uid' AND ";
		if ($timemin!="") $condition .="corpus_article.semestertime >= $timemin AND ";
		if ($timemax!="") $condition .="corpus_article.semestertime < $timemax AND ";
		
		//echo $condition.'<br/>';
		$article = M('article');
		$student = M('student'); 
				
		if ($download == 0) {
			if ($error=="")
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*".$keywords.".*'")->page($page.','.$listnum)->select();
			else
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*\[[^\]]*".$keywords."[^\]]*\,[^\]]*\,[^\]]*".$error."[^\]]*\].*'")->page($page.','.$listnum)->select();
		} else {
			if ($error=="")
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*".$keywords.".*'")->select();
			else
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*\[[^\]]*".$keywords."[^\]]*\,[^\]]*\,[^\]]*".$error."[^\]]*\].*'")->select();
		}
		
		//$list = $article->where("text RLIKE '.*\[[^\]\,]*".$keywords."[^\]\,]*\,[^\]\,]*\,[^\]\,]*".$error."[^\]\,]*\].*'")->page($page.','.$listnum)->select();
		//print_r($list);
				
				
		$array = array(); 
		$ind = 0; 
		foreach ($list as &$item){
			$num = 0;
			$point=0;
			$item['detail']="";
			
			while ($pos=strpos($item['text'], $keywords, $point)){
				//echo $pos.' ';
				$point = $pos+1;
				$sub = my_substr( $item['text'], $pos );
				$matchsub = my_substr( $item['text'], $pos,1 );
				if ($error=="" ){
					if ($download == 1) {
						$item['detail'] .= "...".$sub."...;\n\n ";
					} else {
						$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1)."...<br/>";
					}
				}
				else{
					if (preg_match('|\[[^\]]*'.$keywords.'[^\]]*\,[^\]]*\,[^\]]*'.$error.'[^\]]*\]|', $matchsub, $matches)) {
						if ($download == 1){
							$item['detail'] .= "...".$sub."...; \n\n";
						} else {
							$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1 )."...<br/>";
						}
					}
				}
			}
			if($keyword==""){
				while ($pos=strpos($item['text'], $error, $point)){
					//echo $pos.' ';
					$point = $pos+1;
					$sub = my_substr( $item['text'], $pos );
					$matchsub = my_substr( $item['text'], $pos,1 );
					if (preg_match('|\[[^\]]*\,[^\]]*\,[^\]]*'.$error.'[^\]]*\]|', $matchsub, $matches)) {
							if ($download == 1){
								$item['detail'] .= "...".$sub."...;\n\n ";
							} else {
								$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1 )."...<br/>";
							}
					}
				}
			}
			
			if ($download == 1) {
				array_push($array, Array($item['aid'],$item['uid'],$item['title'],$item['semester'],$item['time'],$item['detail']) );
			}			
			++$ind; 
			//90条截止，防止拖库
			if ($ind > 90) break; 
		}
		
		if ($download == 1){
			$name = "result_".$keywords.".csv"; 
			$title = Array('作品コード','執筆者コード','題目','学期','執筆日','关键字上下文');
			return $this->exportCSV($name, $title, $array);
		} else {
			if (count($list) != 0) $hasResult = 1; else $hasResult = 0; 
			$this->assign("articles", $list);
			if (count($list) == $listnum)
				$this->assign("nextpage", 1); 
			else
				$this->assign("nextpage", 0);  
			
			$this->assign("hasResult", $hasResult); 
			$this->assign("error", $error); 
			$this->assign("page", $page); 
			$this->assign("listnum", $listnum); 
			$this->assign("keywords", $keywords); 
			$this->assign("content", "Search:result");
			$this->display("Search:result");
		}
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