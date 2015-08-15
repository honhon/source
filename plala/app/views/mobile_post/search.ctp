<center>
<h1>郵便番号検索</h1>
<?php
echo('<h2>' . $subject . '</h2>');
if ($act == 'city') {
	if(count($city) == 0){
		echo('<font color="red">ヒットしませんでした</font>');
	}else{
		echo('<table>');
		foreach($city as $v){
			?>
			<tr><td><a href="/p/mobile_post/search/post/<?=$v['code']?>/"><?=$v['name']?></a></td></tr>
			<?
		}
		echo('</table>');
	}
} else {
	if(count($post) == 0){
		echo('<font color="red">ヒットしませんでした</font>');
	}else{
		echo('<table>');
		foreach($post as $k => $v){
			$address = $v['ken_name'] . $v['city_name'] . $v['post_name'];
//			$address2 = mb_ereg_replace(array('以下に.*', '（.*') , array('', ''), $address);
//			$address2 = mb_ereg_replace('以下に', '', $address);
//			$address2 = mb_ereg_match("(以下に)", $address);
			?>
			<tr><td><?=$util->postformat($v['post_code'])?></td><td><a href="http://local.google.co.jp/local?q=<?= urlencode($address); ?>" target="_blank"><?=$address;?></a></td></tr>
			<?
			if(($k + 1) % 20 === 0 && ($k + 1) !== count($post)){
				echo '<tr><td colspan="2" align="right"><a href="#top">▲</a> <a href="#bottom">▼</a></td></tr>';
			}
		}
		echo('</table>');
	}
}
?>
<br />
<a href="/p/mobile_post/">郵便番号検索TOP</a>
<br />
<a href="/p/post/">郵便番号検索 for PC</a>
<br />
</center>
