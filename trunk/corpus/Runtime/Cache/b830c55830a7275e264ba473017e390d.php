<?php if (!defined('THINK_PATH')) exit();?><meta http-equiv="content-type" content="text/html;charset=utf-8"> 
<head>
<script type="text/javascript" src="../Public/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../Public/jquery.qtip-1.0.0-rc3.min.js"></script>
</head> 
<div style="width:800">
<?php echo ($content); ?>
</div>
<script type="text/javascript"> 
$(document).ready(function()
{
   $('b[title]').qtip({
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