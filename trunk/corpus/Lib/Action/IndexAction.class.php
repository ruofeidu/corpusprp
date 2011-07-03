<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action{
    public function index(){
        header("Content-Type:text/html; charset=utf-8");
		//echo"ok!";
        $article=M('article');
		$articles=$article->select();
		//print_r($articles);
		$this->assign("articles", $articles);
		$this->assign("content", "Index:index");
		$this->display("Public:base");
		//foreach ($articles as $a){
			//echo $a['id'].':<a href="'.U('Index/view').'?id='.$a['id'].'&txtid='.$a['semester'].','.$a['aid'].','.$a['uid'].'">'.$a['title'].'</a><br>';
		//}
    }
	public function view(){
		if (!isset($_GET['txtid']) || !isset($_GET['id'])) $this->redirect('Index/index', array(), 2,'参数错误');
        header("Content-Type:text/html; charset=utf-8");
		
		$article=M('article');
		$articleinfo=$article->where("id='{$_GET['id']}'")->find();
		
		$text=M("text");
		$find=$text->where("txtid='".$_GET['txtid']."'")->find();
		if ($find==null) $this->redirect('Index/index', array(), 2,'此文章不存在');
		$content = $find['text'];
		//echo $data;
		$content=str_replace("\n","<br/>",$content);
		preg_match_all('|\[([^\]\,]*),([^\]\,]*),([^\]\,]*)\]|', $content, $matches);
		//print_r($matches);
		//echo '<div style="background-color:green">';
		for ($i=0;$i<count($matches[0]);$i++){
			//echo $matches[0][$i].$matches[1][$i].$matches[2][$i].$matches[3][$i]."<br/>";
			//if ($matches[1][$i]=='' && $matches[2][$i]!='')
			//$content=str_replace($matches[0][$i],'<b style="background-color:green">'.$matches[2][$i].'</b>',$content);
			//if ($matches[1][$i]!='' && $matches[2][$i]=='')
			//$content=str_replace($matches[0][$i],'<b style="background-color:red"><S>'.$matches[1][$i].'</S></b>',$content);
			//if ($matches[1][$i]!='' && $matches[2][$i]=='')
			$errormsg='';
			preg_match_all('|(\w+)|', $matches[3][$i], $error);
			//print_r($error);
			foreach($error[1] as $e){
				//echo $e."<br/>";
				if ($pos=strpos($e,'_')){
					//echo "sub".substr($e,0,$pos).".".substr($e,$pos+1,100).'<br>';
					$Merror=M("error");
					$errorinfo1=$Merror->where('eid="'.substr($e,0,$pos).'"')->find();
					$errorinfo2=$Merror->where('eid="'.substr($e,$pos+1,100).'"')->find();
					$errormsg.="错误类型:".$errorinfo1['type'].$errorinfo2['type']."<br/>错误信息:".$errorinfo1['msg'].'<br/>'.$errorinfo2['msg']."<br/><br/>";
				}else{
					$Merror=M("error");
					$errorinfo=$Merror->where('eid="'.$e.'"')->find();
					$errormsg.="错误类型:".$errorinfo['type']."<br/>错误信息:".$errorinfo['msg']."<br/><br/>";
				}
			}
			
			
			$content=str_replace($matches[0][$i],'&nbsp;<b class="tip" title="'.$errormsg.'"><b id="tip" style="background-color:red"><S>'.$matches[1][$i].'</S></b>'.'<b style="background-color:green">'.$matches[2][$i].'</b></b>',$content);
		}
		$this->assign("a", $articleinfo);
		$this->assign("text", $content);
		$this->assign("content", "Index:view");
		$this->display("Public:base");
	}
	public function update(){
		ini_set('max_execution_time', '1000');
		$article=M('article');
		$articles=$article->select();
		//print_r($articles);
		foreach ($articles as $a){
			$index=$a['semester'].','.$a['aid'].','.$a['uid'];
			$file = "./public/article/".$index.".txt";
			//echo $file;
			//echo "id:".$_GET['id']."<br/>";
			if (file_exists($file)) {
				$content = file_get_contents($file);
				$text=M("text");
				$find=$text->where("txtid='".$index."'")->find();
				//print_r($find);
				if ($find==null){
					$addr['title']=$a['title'];
					$addr['index']=$index;
					$addr['text']=$content;
					$text->add($addr);
				}
			}
			
		}
	}
}
?>