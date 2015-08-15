<script type="text/javascript" src="/js/searchpost.js"></script>
<h1 id="subtitle"><span class="subtitle">■</span>郵便番号検索</h1>
<br clear="all" />

<div id="frame2Right" class="left">
	<!-- <div class="right">xxxx更新</div> -->
	<div id="resultFieldCityList"><select id="cityList"><option value="">▼市町村を選択してください</option></select></div><br />
	<div id="resultField" style="height:400px;overflow:auto;padding-left:20px;"></div>
</div>
<div id="frame2Left">
	<fieldset id="condition1">
		<legend>地域 で 検索</legend>
		<table class="bankkana" width="85%">
			<?php
			for($i = 0; $i < 48; $i++){
				echo (($i % 3) == 0)? '<tr>': '';
				echo '<td>';
				if(isset($ken[$i])){
					?>
					<a href="javascript:searchCity('<?=$ken[$i]['code']?>');"><?=$ken[$i]['name']?></a>
					<?php
				}
				echo '</td>';
				echo (($i % 3) == 2)? '</tr>': '';
			}
			?>
		</table>
	</fieldset>
	<br />
	<fieldset id="condition2">
		〒
		<input type="text" id="pCode1" size="3" maxlength="3" /> -
		<input type="text" id="pCode2" size="4" maxlength="4" />
		<button id="btnSearch">検索</button>
	</fieldset>
	<br />
	<br />
	※携帯端末などJavaScriptが無効の方は<br />&nbsp;&nbsp;&nbsp;
	<a href="/p/mobile_post/">モバイル版</a> をご利用ください
	<br />
</div>
<form name="fmap">
	<input type="hidden" name="q" />
</form>
