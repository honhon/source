<script type="text/javascript" src="/js/searchbank.js"></script>
<h1 id="subtitle"><span class="subtitle">■</span> 支店コード検索(銀行,信用金庫,農協,漁連)</h1>
<br clear="all" />

<div id="frame2Right" class="left">
	<!-- <div class="right">xxxx更新</div> //-->
        <table style="width:100%"><tr>
        <td style="vertical-align:top">
	    <div id="resultFieldBanklist"><select id="bankList"><option value="">▼金融機関名を選択してください</option></select></div><br />
	    <div id="resultField" style="height:400px;overflow:auto;padding-left:20px;"></div>
        </td>
        <td style="vertical-align:top; width:100px;">
            <SCRIPT charset="utf-8" type="text/javascript" src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=GetScriptTemplate"> </SCRIPT> <NOSCRIPT><A HREF="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhonplalajp-22%2F8009%2F228c88a3-b718-4e8a-b381-122fd1270929&Operation=NoScript">Amazon.co.jp ウィジェット</A></NOSCRIPT>
        </td>
        </tr></table>
</div>
<div id="frame2Left">
	<fieldset id="condition1">
		<legend>カナ で 検索</legend>
		<span style="font-size:10px;color:#666666;">金融機関名の頭文字を選択してください。</span><br />
		<table class="bankkana" width="85%">
			<?foreach($aryKanaHead as $kanaNo => $kana){ ?>
				<?if(($kanaNo % 10) == 0){ echo('<tr>'); }?>
				<td><?if($kana != '-'){ ?><a href="javascript:searchBank('<?=$kana?>');"><?=$aryKanaHeadZen[$kanaNo]?></a><?}?></td>
				<?if(($kanaNo % 10) == 9){ echo('</tr>'); }?>
			<?}?>
		</table>
		<div id="condition1kana">
			<table class="bankkana" width="85%">
				<tr><td colspan="10" class="center"><b>--- 支店名頭文字で絞込 ---</b></td></tr>
				<?foreach($aryKanaHead as $kanaNo => $kana){ ?>
					<?if(($kanaNo % 10) == 0){ echo('<tr>'); }?>
					<td><?if($kana != '-'){ ?><a href="javascript:searchShitenKana('<?=$kana?>')"><?=$aryKanaHeadZen[$kanaNo]?></a><?}?></td>
					<?if(($kanaNo % 10) == 9){ echo('</tr>'); }?>
				<?}?>
				<tr><td colspan="10" class="center"><a href="javascript:searchShitenKana('')">全支店表示</a></td></tr>
			</table>
		</div>
	</fieldset>
	<br />
	<fieldset id="condition2">
		<legend>都市銀行 を 検索</legend>
		<table>
		<?foreach($aryMainBank as $bankCode => $bankName){ ?>
			<tr>
				<td>・<a href="javascript:searchCityBank('<?=$bankCode?>');"><?=$bankName?></a></td>
				<td><? if(isset($aryMainBankUrl[$bankCode])){?>[ <a href="<?=$aryMainBankUrl[$bankCode]?>" target="_blank">home</a> ]<?}?></td>
			</tr>
		<?}?>
		</table>
		<div id="condition2kana">
			<table class="bankkana" width="85%">
				<tr><td colspan="10" class="center"><b>--- 支店名頭文字で絞込 ---</b></td></tr>
				<?foreach($aryKanaHead as $kanaNo => $kana){ ?>
					<?if(($kanaNo % 10) == 0){ echo('<tr>'); }?>
					<td><?if($kana != '-'){ ?><a href="javascript:searchShitenKana('<?=$kana?>')"><?=$aryKanaHeadZen[$kanaNo]?></a><?}?></td>
					<?if(($kanaNo % 10) == 9){ echo('</tr>'); }?>
				<?}?>
				<tr><td colspan="10" class="center"><a href="javascript:searchShitenKana('')">全支店表示</a></td></tr>
			</table>
		</div>
	</fieldset>
	<br />
	<fieldset id="condition3">
		<legend>コード で 検索</legend>
		銀行コード: <input type="text" id="bCode" size="4" maxlength="4" /><br />
		支店コード: <input type="text" id="sCode" size="4" maxlength="3" />
		<button id="btnSearch">検索</button>
	</fieldset>
	<br />
	<br />
	<a href="javascript:help();">ヘルプ</a>
	<br />
	<br />
	※携帯端末などJavaScriptが無効の方は<br />&nbsp;&nbsp;&nbsp;
	<a href="/p/mobile_bank/">モバイル版</a> をご利用ください
	<br />
</div>
<form id="fmap" target="jp.plala.hon.map" action="/p/bank/map/" method="post">
	<input type="hidden" name="bankCode"   id="fmapBankCode" />
	<input type="hidden" name="shitenCode" id="fmapShitenCode" />
	<input type="hidden" name="shitenSeq"  id="fmapShitenSeq" />
</form>
