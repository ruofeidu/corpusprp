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
		
		$News = M('form'); 
		$a = $News->getById(14); 
		$this->assign("newsInfo", $a);
		$a = $News->getById(15); 
		$this->assign("newsAbout", $a);
		$this->display();
			
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
		
		if ($i == 1) echo L("sorry_no_pic"); 
		$this->assign("txtid", $txtid); 
		$this->assign("picture", $a); 
		$this->display();
	}
	//浏览作文详细内容
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->error(L('para_wrong'));		
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null){ $admin_user = true; } else { $admin_user = false;  }
		$this->assign("admin_user", $admin_user);
		
		$article = M('article');
		$find = $article->where("id='{$_GET['id']}'")->find();
		
		if ($find['text'] == null) $this->error(L('article_no_exist'));
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
		header("Content-Type:text/plain; charset=utf-8");    
		header("Content-Disposition:attachment;filename=$name"); 
		header("Pragma:no-cache");     
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
	
	public function search(){
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] != null){ $admin_user = true; } else { $admin_user = false;  }
		$this->assign("admin_user", $admin_user);
		
		if (!$admin_user && $_SESSION['_ACCESS_LIST']['CORPUS']['SEARCH']['SEARCH0'] == null)
		{
			echo L('search0_error');
			exit();
		}
		if (!$admin_user && $download == 1 && $_SESSION['_ACCESS_LIST']['CORPUS']['SEARCH']['exportCSV'] == null)
		{
			echo L('download_error');
			exit();
		}
		//dump( $_SESSION['_ACCESS_LIST']);
	
		if ( (!isset($_POST['keywords'])||$_POST['keywords']==""||$_POST['keywords']=='ss'||strlen($_POST['keywords'])<2) && (!isset($_POST['error'])||$_POST['error']=="") ) {
			if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] == null) { // Admin is not limited by keyword length
				if (strlen($_POST['keywords']) < 2 || $_POST['keywords'] == 'ss'){
					echo L('please_right_key');
					exit();
				}
			}
		}
		
		$keywords = $_POST['keywords'];
		if (!isset($_POST['error'])) $error = "";	else $error = $_POST['error']; 
		if (isset($_POST['page'])) $page = $_POST['page']; else $page = 1;
		if (isset($_POST['listnum'])) $listnum = $_POST['listnum']; else $listnum = 30;
		if (isset($_POST['download'])) $download = $_POST['download']; else $download = 0;
		//echo $keywords.":".$error;
		
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		$firstlang = $_POST['firstlang'];
		$semester = $_POST['year'];
		$uid = $_POST['uid'];
		$timemin = $_POST['timemin'];
		$timemax = $_POST['timemax'];
		
		$condition = "";
		if ($school!="") $condition .="corpus_article.aid LIKE '$school%' AND ";
		if ($gender!="") $condition .="corpus_student.gender='$gender' AND ";
		if ($firstlang!="") $condition .="corpus_student.firstlang='$firstlang' AND ";
		if ($semester!="") $condition .="corpus_article.semester='$semester' AND ";
		if ($uid!="") $condition .="corpus_article.uid='$uid' AND ";
		if ($timemin!="") $condition .="corpus_article.semestertime >= $timemin AND ";
		if ($timemax!="") $condition .="corpus_article.semestertime < $timemax AND ";
		
		//echo $condition.'<br/>';
		$article = M('article');
		$student = M('student'); 
				
		// limit rule added by zdq
		$selectnum = $listnum;
		
		if (!$admin_user && $_SESSION['_ACCESS_LIST']['CORPUS']['SEARCH']['SEARCH2'] == null)
		{
			$page = 1;
			$selectnum = 20;
		}
		else
		if ($_SESSION['_ACCESS_LIST']['CORPUS']['SEARCH']['SEARCH3'] == null)
		{
			if ($page * $listnum > 100)
			{
				$page = (int)(100 / $listnum) + 1; 
				$selectnum = 100 % $listnum; 
			}
		}
		else
		if (!$admin_user && $_SESSION['_ACCESS_LIST']['CORPUS']['SEARCH']['SEARCH4'] == null)
		{
			if ($page * $listnum > 200)
			{
				$page = (int)(100 / $listnum) + 1; 
				$selectnum = 100 % $listnum; 
			}
		}
				
		if ($download == 0) {
			if ($error=="")
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*".$keywords.".*'")->page($page.','.$selectnum)->select();
			else
				$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*\[[^\]]*".$keywords."[^\]]*\,[^\]]*\,[^\]]*".$error."[^\]]*\].*'")->page($page.','.$selectnum)->select();
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
			$point = 0;
			$item['detail']="";
			
			$iterwords = $keywords;
			if ($iterwords=="") $iterwords = $error;
			
			while ($pos = strpos($item['text'], $iterwords, $point))
			{
				$point = $pos + 1;
				$sub = my_substr($item['text'], $pos);
				$matchsub = my_substr($item['text'], $pos, 1);
				
				$sub_above = "";
				$sub_below = "";
				split_context($sub, $iterwords, $sub_above, $sub_below);
				
				$filt_words   = array("\r\n", "\n", "\r");
				$sub_above = str_replace($filt_words, "", $sub_above);
				$sub_below = str_replace($filt_words, "", $sub_below);
				
				$error_match = false;
				if ($error == "")
					$error_match = true;
				else if ($keyword == "")
					$error_match = preg_match('|\[[^\]]*\,[^\]]*\,[^\]]*'.$error.'[^\]]*\]|', $matchsub, $matches);
				else
					$error_match = preg_match('|\[[^\]]*'.$keywords.'[^\]]*\,[^\]]*\,[^\]]*'.$error.'[^\]]*\]|', $matchsub, $matches);
				if ($error_match)
				{
					if ($download == 1)
					{
						$item['detail'] .= "...".$sub."...; \n\n";
						// $item['detail_single'] = "...".$sub."...";
						// array_push($array, Array($item['aid'],$item['uid'],$item['title'],$item['semester'],$item['time'],$item['detail_single']) );
						$item['detail_key'] = $iterwords;
						$item['detail_above'] = "...".$sub_above;
						$item['detail_below'] = $sub_below."...";
						array_push($array, Array($item['aid'],$item['uid'],$item['title'],$item['semester'],$item['time'],$item['detail_above'],$item['detail_key'],$item['detail_below']) );
					} else
					{
						$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1 )."...<br/>";
					}
				}
			}
			
			++$ind; 
			//90条截止，防止拖库
			if ($_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] == null && $ind > 120) break; 
			//if ($ind > 10000) break; 
		} 
		
		if ($download == 1){
		
			
		
			$name = "result_".$keywords.".csv"; 
			// $title = Array(L('work_id'), L('author_id'), L('title'),L('semester'), L('date'), L('context'));
			$title = Array(L('work_id'), L('author_id'), L('title'),L('semester'), L('date'), L('context_above'), L('context_key'), L('context_below'));
			return $this->exportCSV($name, $title, $array);
		} else {
			if (count($list) != 0) $hasResult = 1; else $hasResult = 0; 
			$this->assign("articles", $list);
			if (count($list) == $listnum){
				$this->assign("nextpage", 1); 
				$endnum = $page + 1; 
			} else {
				$this->assign("nextpage", 0);  
				$endnum = $page;
			}
			$startnum = max(1, $page - 4); 
			
			$allpage = array();
			for ($i = $startnum; $i <= $endnum; ++$i){
				$allpage[] = $i; 
			}
			
			$this->assign("hasResult", $hasResult); 
			$this->assign("allpage", $allpage); 
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