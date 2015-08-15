<center>
<h1>金融機関支店番号検索</h1>
金融機関の頭文字を選択してください
<table>
<?
foreach($aryKanaHead as $kanaNo => $kana){
	echo ((($kanaNo % 10) == 0)? '<tr>': '');
	echo ('<td>');
	echo (($kana == '-')? '　': ' <a href="/p/mobile_bank/search/' . urlencode($kana) . '/">' . $aryKanaHeadZen[$kanaNo] . '</a> ');
	echo ('</td>');
	echo ((($kanaNo % 10) == 9)? '</tr>': '');
}
?>
</table>
<br />
<div>---------------------------</div>
都市銀行検索ショートカット<br />
<table>
<? foreach($aryMainBank as $bankCode => $bankName){ ?>
	<tr>
		<td><a href="/p/mobile_bank/search/<?=$bankCode?>/"><?=$bankName?></a></td>
	</tr>
<? }?>
</table>
<div>---------------------------</div>
<br />
<a href="/p/mobile_bank/">支店番号検索TOP</a>
<br />
<a href="/p/bank/">支店番号検索 for PC</a>
<br />
</center>
