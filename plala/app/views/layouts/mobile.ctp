<html>
<head>
<?php echo $html->charset('Shift_JIS'); ?>
<title><?php echo $title; ?></title>
<?php
	if(isset($meta_keywords))   { echo '<meta name="keywords" content="' . h($meta_keywords) . '" />'; }
	if(isset($meta_description)){ echo '<meta name="description" content="' . h($meta_description) . '" />'; }
?>
<style type="text/css">
 * {font-size:12px;}
</style>
</head>
<body>
<a name="top"></a>
<center>
<div style="background-color:#334455;">
<font color="white">Hon.plala.jp</font>
</div>
<br />
<?php echo $content_for_layout; ?>
<br />
<div style="background-color:#334455;">
<font color="white">Copyright (C)2005-<?php echo date('Y')?> Hon Project  All rights reserved.</font>
</div>
<div>[ <a href="/">Home</a> ]</div>
</center>
<a name="bottom"></a>
<?php echo $cakeDebug; ?>
<?php if($_SERVER['SERVER_PORT'] == 80 && $_SERVER['HTTP_HOST'] == 'hon.plala.jp'){ ?>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	<script type="text/javascript">
	  _uacct = "UA-1399109-1";
	  urchinTracker();
	</script>
<?php } ?>
</body>
</html>
