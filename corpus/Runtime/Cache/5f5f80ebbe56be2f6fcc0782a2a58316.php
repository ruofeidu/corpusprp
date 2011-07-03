<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <!-- 系统CSS样式清空 -->
	<link rel="stylesheet" type="text/css" href="../Public/css/reset-min.css" />
	
	<script type="text/javascript" src="../Public/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="../Public/jquery.qtip-1.0.0-rc3.min.js"></script>
	
    <!-- Grid CSS框架库|布局用 -->
    <link href="../Public/css/grid.css" rel="stylesheet" />
    <!-- 俺们自己写的CSS -->
    <link href="../Public/css/style.css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>Corpus PRP</title>

</head>

<body>
    <div id="superheader">
        <div class="row">
            <div class="column grid_6">
               <div class="nav">
					<?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): ++$i;$mod = ($i % 2 )?><div class="nav-item"><a id='<?php echo ($nav['id']); ?>' href='<?php echo ($nav['href']); ?>' <?php if ($nav['npage']) echo 'target="_blank"'; ?> ><?php echo ($nav['title']); ?></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
                    
                </div>
            </div>
            
    </div>
	</div>
    <div id="header" class="row b-l">
        <div id="logo"><a href="<?php echo U("Index/index");?>">Corpus</a></div>
                <div class="column grid_3">
						<?php if(is_array($subnavs)): $i = 0; $__LIST__ = $subnavs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): ++$i;$mod = ($i % 2 )?><div class="subnav">
							<div class="subnav-item"><a id='<?php echo ($nav['id']); ?>' href='<?php echo ($nav['href']); ?>' <?php if ($nav['npage']) echo 'target="_blank"'; ?> ><?php echo ($nav['title']); ?></a></div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

    </div>