<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action{

    public function index(){
        header("Content-Type:text/html; charset=utf-8");
        $article = M('article');
		$articles = $article->select();
		//print_r($articles);
		$this->assign("articles", $articles);
		$this->assign("content", "Index:index");
		$this->display("Public:base");
		
		/*
		foreach ($articles as $a){
			echo $a['id'].':<a href="'.U('Index/view').'?id='.$a['id'].'&txtid='.$a['semester'].','.$a['aid'].','.$a['uid'].'">'.$a['title'].'</a><br>';
		}
		*/
    }
	
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->redirect('Index/index', array(), 2,'参数错误');
        header("Content-Type:text/html; charset=utf-8");
		
		$article = M('article');
		$articleinfo = $article->where("id='{$_GET['id']}'")->find();
		
		$text = M("text");
		$find = $text->where("txtid='".$_GET['txtid']."'")->find();
		if ($find == null) $this->redirect('Index/index', array(), 2,'此文章不存在');
		$content = $find['text'];
		//echo $data;
		$content = str_replace("\n","<br/>",$content);
		preg_match_all('|\[([^\]\,]*),([^\]\,]*),([^\]\,]*)\]|', $content, $matches);
		//print_r($matches);
		//echo '<div style="background-color:green">';

		for ($i = 0; $i < count($matches[0]); $i++){
			//echo $matches[0][$i].$matches[1][$i].$matches[2][$i].$matches[3][$i]."<br/>";
			//if ($matches[1][$i]=='' && $matches[2][$i]!='')
			//$content=str_replace($matches[0][$i],'<b style="background-color:green">'.$matches[2][$i].'</b>',$content);
			//if ($matches[1][$i]!='' && $matches[2][$i]=='')
			//$content=str_replace($matches[0][$i],'<b style="background-color:red"><S>'.$matches[1][$i].'</S></b>',$content);
			//if ($matches[1][$i]!='' && $matches[2][$i]=='')
			$errormsg = '';
			preg_match_all('|(\w+)|', $matches[3][$i], $error);
			//print_r($error);
			foreach($error[1] as $e){
				//echo $e."<br/>";
				if ($pos = strpos($e,'_')){
					//echo "sub".substr($e,0,$pos).".".substr($e,$pos+1,100).'<br>';
					$Merror = M("error");
					$errorinfo1 = $Merror->where('eid="'.substr($e,0,$pos).'"')->find();
					$errorinfo2 = $Merror->where('eid="'.substr($e,$pos+1,100).'"')->find();
					$errormsg.="错误类型:".$errorinfo1['type'].$errorinfo2['type']."<br/>错误信息:".$errorinfo1['msg'].'<br/>'.$errorinfo2['msg']."<br/><br/>";
				}else{
					$Merror = M("error");
					$errorinfo = $Merror->where('eid="'.$e.'"')->find();
					$errormsg.="错误类型:".$errorinfo['type']."<br/>错误信息:".$errorinfo['msg']."<br/><br/>";
				}
			}
			//#EE2C2C: red; #B3EE3A: green #ADFF2F
			$content = str_replace($matches[0][$i], '&nbsp;<b class="tip" title="'.$errormsg.'"><b id="tip" style="background-color:#EE4000"><S>'.$matches[1][$i].'</S></b>'.'<b style="background-color:#ADFF2F">'.$matches[2][$i].'</b></b>',$content);
		}
		
		//	#FFFF6F: yellow
		if (isset($_GET['keywords'])) {
			$content = str_replace($_GET['keywords'], '&nbsp;<b id="tip" style="background-color:#FFFF6F">'.$_GET['keywords'].'</b>', $content);
		}
		
		$this->assign("a", $articleinfo);
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
		if ( !isset($_POST['keywords']) ) $this->redirect('Index/index', array(), 2, '参数错误');
        header("Content-Type:text/html; charset=utf-8");
		
		$keywords = $_POST['keywords'];
		$search_type = $_POST['searchtype'];
		$error = $_POST['error']; 
		$school = $_POST['school'];
		$gender = $_POST['gender'];  
		$people = $_POST['people'];
		$firstlang = $_POST['firstlang'];
		$year = $_POST['year'];
		
		$article = M('article');
		$text = M("text");
		$student = M('student'); 
		
		$articles = $article->select();
		$result = array(); 
		$n = count($articles);
		
		if ($search_type == 'all') {
			$find = $text->where("text LIKE '%".$keywords."%'")->select();
		} else 
		if ($search_type == 'error') {
			$find = $text->where("text LIKE '%".$keywords."%'")->select();
			//$find = $text->where("text LIKE '%しかし%' ESCAPE '\'")->select();
			//$find = $text->where("%\[*[!\]\,]*" . $keywords . "*,*[!\]\,]*,*[!\]\,]*\]% escape '\'")->select();
		} else {
			//$find = $text->where("\[([^\]\,]%),([^\]\,]%" . $keywords . "%),([^\]\,]%)\]")->select();
			$find = $text->where("text LIKE '%".$keywords."%'")->select();
		}
		
		foreach ($find as $item){
			list($semester, $aid, $uid) = split(',', $item['txtid']); 
			
			$student_info = $student->where("uid='".$uid."'")->find(); 
			
			if ($school != 'all' && $student_info['school'] != $school) continue; 
			if ($gender != 'all' && $student_info['gender'] != $gender) continue; 
			if ($people != 'all' && $student_info['people'] != $people) continue; 
			if ($firstlang != 'all' && $student_info['firstlang'] != $firstlang) continue; 
			if ($year != 'all' && $student_info['year'] != $year) continue; 
			
			$articles = $article->where("semester='" .$semester. "' AND aid='" .$aid. "' AND uid='" .$uid. "'")->find();
			
			array_push($result, $articles);
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
			$file = "./public/article/".$index.".txt";
			//echo $file;
			//echo "id:".$_GET['id']."<br/>";
			if (file_exists($file)) {
				$content = file_get_contents($file);
				$text = M("text");
				$find = $text->where("txtid='".$index."'")->find();
				//print_r($find);
				if ($find == null){
					$addr['title'] = $a['title'];
					$addr['index'] = $index;
					$addr['text'] = $content;
					$text->add($addr);
				}
			}
		}
	}
}
?>