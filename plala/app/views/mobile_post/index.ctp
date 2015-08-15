<?php
if(isset($msg) && $msg != ''){
	echo('<font color="red"><hr>' . $msg . '<hr></font>');
}
?>
<center>
<h1>郵便番号検索</h1>
地域 で 検索<br />
<table>
<?php
for($i = 0; $i < 48; $i++){
	echo (($i % 3) == 0)? '<tr>': '';
	echo '<td>';
	if(isset($ken[$i])){
		?>
		<a href="/p/mobile_post/search/city/<?=$ken[$i]['code']?>/"><?=$ken[$i]['name']?></a>
		<?php
	}
	echo '</td>';
	echo (($i % 3) == 2)? '</tr>': '';
}
?>
</table>
<br />
<br />
<form action="/p/mobile_post/search/" method="post">
コード で 検索<br />
〒
<input type="text" name="postcode" size="7" maxlength="7" />
<input type="submit" value="検索" />
<br />
※ハイフンを使わず、3-7桁の<br />
数字を入力してください
</form>
<br />
<a href="/p/mobile_post/">郵便番号検索TOP</a>
<br />
<a href="/p/post/">郵便番号検索 for PC</a>
<br />
</center>
