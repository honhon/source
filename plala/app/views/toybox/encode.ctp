<script language="javascript">
	$(document).ready(function(){
		/* window onload */
		
		$('#btnUrlEncode').click(    function(){ translate(1, $('#resultUrlEncode_1').val(), $('#resultUrlEncode_2')); });
		$('#btnUrlDecode').click(    function(){ translate(2, $('#resultUrlEncode_2').val(), $('#resultUrlEncode_1')); });
		$('#btnBase64').click(       function(){ translate(3, $('#resultBase64_1').val(),    $('#resultBase64_2')); });
		$('#btnBase64Decode').click( function(){ translate(4, $('#resultBase64_2').val(),    $('#resultBase64_1')); });
		$('#btnMd5').click(          function(){ translate(5, $('#resultMd5_1').val(),       $('#resultMd5_2')); });
	});
	
	function translate(act, source, target){
		$('#msg').html('');
		target.val("変換中.....").css('background-color', '#ddddff').css('color', '#aaaaaa');
		var charsettype = $("input:radio[@name='charsettype']:checked").val();
		$.ajax({url:      '/p/toybox/encode/'
			  , type:     'post'
			  , data:     {'act':act,'source':source,'charsettype':charsettype}
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { target.css('background-color', '').css('color', ''); $('#msg').html('<hr />通信エラー<hr />'); }
			  , success:  function(res){ target.val(res).css('background-color', '').css('color', ''); }
		});
	}
</script>
<style type="text/css">
	#msg {color:red;}
</style>

<h1 id="subtitle"><span class="subtitle">■</span> URL Encode</h1>
<br clear="all" />
<div id="msg"></div>
<div class="right">
	<input type="radio" name="charsettype" value="0" id="char1" checked><label for="char1">UTF-8</label>
	<input type="radio" name="charsettype" value="1" id="char2"        ><label for="char2">EUC-JP</label>
	<input type="radio" name="charsettype" value="2" id="char3"        ><label for="char3">Shift-JIS</label>
</div>

<div class="left">【URLEncode】</div>
<table>
<tr>
	<td><textarea cols="50" rows="5" id="resultUrlEncode_1"></textarea></td>
	<td>
		<button id="btnUrlEncode">encode &gt;&gt;</button><br /><br />
		<button id="btnUrlDecode">&lt;&lt; decode</button>
	</td>
	<td><textarea cols="50" rows="5" id="resultUrlEncode_2"></textarea></td>
</tr>
</table>
<br />

<div class="left">【BASE64】</div>
<table>
<tr>
	<td><textarea cols="50" rows="5" id="resultBase64_1"></textarea></td>
	<td>
		<button id="btnBase64">encode &gt;&gt;</button><br /><br />
		<button id="btnBase64Decode">&lt;&lt; decode</button>
	</td>
	<td><textarea cols="50" rows="5" id="resultBase64_2"></textarea></td>
</tr>
</table>
<br />

<div class="left">【MD5】</div>
<table>
<tr>
	<td><textarea cols="50" rows="5" id="resultMd5_1"></textarea></td>
	<td>
		<button id="btnMd5">encode &gt;&gt;</button><br /><br />
	</td>
	<td><textarea cols="50" rows="5" id="resultMd5_2"></textarea></td>
</tr>
</table>
<br />
