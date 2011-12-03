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
		$this->display("Search:base");
	}
	
	//搜索
	public function search(){
		//if ( (!isset($_POST['keywords'])||$_POST['keywords']=="") && (!isset($_POST['error'])||$_POST['error']=="") ) $this->error('请输入关键字');
		$keywords = $_POST['keywords'];
		if (!isset($_POST['error']))
		$error="";
		else $error = $_POST['error']; 
		if (isset($_GET['page'])) $page = $_GET['page'];
		else $page = 1;
		$listnum = 30;
		//echo $keywords.":".$error;
		
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		$studytime = $_POST['studytime'];
		$firstlang = $_POST['firstlang'];
		$semester = $_POST['year'];
		$uid = $_POST['uid'];
		
		$condition = "";
		if ($school!="") $condition .="corpus_student.school='$school' AND ";
		if ($gender!="") $condition .="corpus_student.gender='$gender' AND ";
		if ($studytime!="") $condition .="corpus_student.studytime='$studytime' AND ";
		if ($firstlang!="") $condition .="corpus_student.firstlang='$firstlang' AND ";
		if ($semester!="") $condition .="corpus_article.semester='$semester' AND ";
		if ($uid!="") $condition .="corpus_article.uid='$uid' AND ";
		//echo $condition.'<br/>';
		$article = M('article');
		$student = M('student'); 
				
		if ($error=="")
			$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*".$keywords.".*'")->page($page.','.$listnum)->select();
		else
			$list = $article->field('corpus_article.*')->join('corpus_student ON corpus_article.uid = corpus_student.uid')->where($condition."text RLIKE '.*\[[^\]]*".$keywords."[^\]]*\,[^\]]*\,[^\]]*".$error."[^\]]*\].*'")->page($page.','.$listnum)->select();
			//$list = $article->where("text RLIKE '.*\[[^\]\,]*".$keywords."[^\]\,]*\,[^\]\,]*\,[^\]\,]*".$error."[^\]\,]*\].*'")->page($page.','.$listnum)->select();
		//print_r($list);
				
		foreach ($list as &$item){
			$num = 0;
			$point=0;
			$item['detail']="";
			while ($pos=strpos($item['text'], $keywords, $point)){
				
					$point = $pos+1;
					$sub = my_substr( $item['text'], $pos );
					$matchsub = my_substr( $item['text'], $pos,1 );
					if ($error=="" ){
						$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1)."...<br/>";
					}
					else{
						if (preg_match('|\[[^\]]*'.$keywords.'[^\]]*\,[^\]]*\,[^\]]*'.$error.'[^\]]*\]|', $matchsub, $matches))
							$item['detail'] .= "...".format_text( $sub,$keywords, $error, 1 )."...<br/>";
					}
				}	
			
		}

		$this->assign("articles", $list);
		$this->assign("error", $error); 
		$this->assign("page", $page); 
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