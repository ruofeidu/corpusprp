<?php if (!defined('THINK_PATH')) exit();?><div class="row main">
	<div class="column grid_9">
		<table width="100%">
			<tr>
				<th>作品コード</th><th>執筆者コード</th><th>題目</th><th>学期</th><th>執筆日</th>
			</tr>
			<?php if(is_array($articles)): $i = 0; $__LIST__ = $articles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): ++$i;$mod = ($i % 2 )?><tr>
					<td><?php echo ($a["aid"]); ?></td><td><?php echo ($a["uid"]); ?></td><td><a href="<?php echo U('Index/view');?>?id=<?php echo ($a["id"]); ?>&txtid=<?php echo ($a["semester"]); ?>,<?php echo ($a["aid"]); ?>,<?php echo ($a["uid"]); ?>"><?php echo ($a["title"]); ?></td><td><?php echo ($a["semester"]); ?></td><td><?php echo ($a["time"]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</div>