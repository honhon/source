<center>
<h1>金融機関支店番号検索</h1>
<table><tr>
<td style="vertical-align:top;">
<?
if(count($bankInfo) == 0){
	echo('<font color="red">ヒットしませんでした</font>');
}else{
?>
	<table>
	<? foreach($bankInfo as $bank){ ?>
		<tr>
			<td><a href="/p/mobile_bank/search/<?=$bank['bank_code']?>/"><?=$bank['bank_code']?></a> :</td>
			<td><a href="/p/mobile_bank/search/<?=$bank['bank_code']?>/"><?=$bank['bank_name']?></a></td>
		</tr>
	<? }?>
	</table>
<? }?>
</td>
<td style="vertical-align:top;">
<SCRIPT charset="utf-8" type="text/javascript" src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=GetScriptTemplate"> </SCRIPT> <NOSCRIPT><A HREF="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=NoScript">Amazon.co.jp ウィジェット</A></NOSCRIPT>
</td></tr></table>
<br />
<a href="/p/mobile_bank/">支店番号検索TOP</a>
<br />
<a href="/p/bank/">支店番号検索 for PC</a>
<br />
</center>

