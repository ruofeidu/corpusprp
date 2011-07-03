<?php if (!defined('THINK_PATH')) exit();?><div class="row">
<div class="column grid_6"><p class="articletitle"><?php echo ($a["title"]); ?></p></div>
<div class="column grid_3"><p class="pagetopnav"><a href="<?php echo U('Index/Index'); ?>">返回</a></div>
</div>
<div class="row main">
<div class="column grid_6">
	<div class="articletext"><?php echo ($text); ?></div>
</div>
<div class="column grid_3">
	<table width="100%">
		<tr><th>文章信息</th></tr>
		<tr><td>作品コード</td><td><?php echo ($a["aid"]); ?></td></tr>
		<tr><td>執筆者コード</td><td><?php echo ($a["uid"]); ?></td></tr>
		<tr><td>題目</td><td><?php echo ($a["title"]); ?></td></tr>
		<tr><td>文体</td><td><?php echo ($a["type"]); ?></td></tr>
		<tr><td>学期</td><td><?php echo ($a["semester"]); ?></td></tr>
		<tr><td>学習時間数</td><td><?php echo ($a["semestertime"]); ?></td></tr>
		<tr><td>執筆日</td><td><?php echo ($a["time"]); ?></td></tr>
		<tr><td>辞書の使用</td><td><?php echo ($a["usebook"]); ?></td></tr>
		<tr><td>時間制限</td><td><?php echo ($a["timelimit"]); ?></td></tr>
		<tr><td>添削者</td><td><?php echo ($a["modifiedby"]); ?></td></tr>		
		<tr><td>タグ付者</td><td><?php echo ($a["markedby"]); ?></td></tr>
		<tr><td>タグ付項目</td><td><?php echo ($a["mark"]); ?></td></tr>
		<tr><td>タグ付完成日</td><td><?php echo ($a["finishedday"]); ?></td></tr>
		<tr><td>字数</td><td><?php echo ($a["wordnum"]); ?></td></tr>	
		<tr><td>入力者</td><td><?php echo ($a["inputed"]); ?></td></tr>	
		<tr><td>入力完成日</td><td><?php echo ($a["inputedday"]); ?></td></tr>	
	</table>
</div>
<script type="text/javascript"> 
$(document).ready(function()
{
   $('.tip[title]').qtip({
      position: {
         corner: {
            target: 'bottomRight',
            tooltip: 'topLeft'
         }
      },
      style: {
         name: 'cream',
         padding: '7px 13px',
         width: {
            max: 300,
            min: 0
         },
         tip: true
      }
   });
});
</script> 
</div>