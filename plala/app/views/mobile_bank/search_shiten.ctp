<center>
<h1>金融機関支店番号検索</h1>
<?
if(count($bankInfo) > 0){
	echo('<h2>[ ' . $bankInfo[0]['bank_code'] . ' ] ' .  $bankInfo[0]['bank_name'] . ' ( ' . $bankInfo[0]['bank_kana'] . ' )</h2>');
}
?>

<table><tr>
<td style="vertical-align:top;">
<?
if(count($shitenInfo) == 0){
	echo('<font color="red">ヒットしませんでした' . (isset($kana)? '(' . $kana . ')': '') . '</font><br />');
}else{
	echo('<table>');
	foreach($shitenInfo as $k => $shiten){
//<td><a href="http://local.google.co.jp/local?q=< echo urlencode($shiten['address']); >" target="_blank">< echo $shiten['shiten_name']></a></td>
	?>
		<tr>
			<th><? echo $shiten['shiten_code']?>: </th>
			<td><? echo $shiten['shiten_name']?></td>
		</tr>
	<?
		if(($k + 1) % 20 === 0 && ($k + 1) !== count($shitenInfo)){
			echo '<tr><td colspan="2" align="right"><a href="#top">▲</a> <a href="#bottom">▼</a></td></tr>';
		}
	}
	echo('</table>');
}
?>
</td>
<td style="vertical-align:top;">
<SCRIPT charset="utf-8" type="text/javascript" src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=GetScriptTemplate"> </SCRIPT> <NOSCRIPT><A HREF="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=NoScript">Amazon.co.jp ウィジェット</A></NOSCRIPT>
</td>
</tr></table>
<?
if(count($bankInfo) > 0){
?>
	<div>---------------------------</div>
	支店の頭文字で絞込検索<br />
	<table>
	<?
	foreach($aryKanaHead as $kanaNo => $kana){
		echo ((($kanaNo % 10) == 0)? '<tr>': '');
		echo ('<td>');
		echo (($kana == '-')? '　': ' <a href="/p/mobile_bank/search/' . $bankInfo[0]['bank_code'] . '/' . urlencode($kana) . '/">' . $aryKanaHeadZen[$kanaNo] . '</a> ');
		echo ('</td>');
		echo ((($kanaNo % 10) == 9)? '</tr>': '');
	}
	?>
	</table>
	<div>---------------------------</div>
<?
}
if(count($bankInfo) > 0){
	echo('<h3><a href="/p/mobile_bank/search/' . $bankInfo[0]['bank_code'] . '/">' .  $bankInfo[0]['bank_name'] . '</a></h3>');
}
?>
<a href="/p/mobile_bank/">支店番号検索TOP</a>
<br />
<a href="/p/bank/">支店番号検索 for PC</a>
<br />
</center>
