<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title><?php echo $title; ?></title>
<?php
	if(isset($meta_keywords))   { echo '<meta name="keywords" content="' . h($meta_keywords) . '" />'; }
	if(isset($meta_description)){ echo '<meta name="description" content="' . h($meta_description) . '" />'; }
?>
	<link rel="stylesheet" type="text/css" href="/css/main.css" />
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
<center>
<div id="frameMain">
	<div class="header1">
		<!--<a href="/" class="header1">Hon<span style="font-size:10px;" class="header1">.plala.</span>jp</a> //-->
		<a href="/" style="color:white;font-size:24px;">Hon<span style="color:white;font-size:10px;">.plala.</span>jp</a>
	</div>
	<div class="header2">
		<a href="http://astore.amazon.co.jp/honplalajp-22/250-2943602-8421820" class="header2" target="_blank">キャラクターショップ</a>
		<a href="http://www.amazon.co.jp/?_encoding=UTF8&tag=honplalajp-22" class="header2" target="_blank">AMAZON.CO.JP</a>
		<a href="/p/toybox/ask/" class="header2">お問い合わせ</a>
		<?php if($_SERVER['SERVER_PORT'] == 80){ ?>
                    <a href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>" class="header2">SSL</a>
		<?php } ?>
	</div>
	<br clear="all" />

	<div>
		<?php echo $content_for_layout; ?>
	</div>
	<?php echo $cakeDebug; ?>
	
	<br clear="all" />
	<div class="footer1">
		Copyright (C)2005-<?php echo date('Y')?> Hon Project  All rights reserved.
	</div>
	<div class="footer2">[ <a href="/">Home</a> ]</div>
</div>
</center>

<?php if($_SERVER['SERVER_PORT'] == 80 && $_SERVER['HTTP_HOST'] == 'hon.plala.jp'){ ?>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	<script type="text/javascript">
	  _uacct = "UA-1399109-1";
	  urchinTracker();
	</script>
<?php } ?>
</body>
</html>
