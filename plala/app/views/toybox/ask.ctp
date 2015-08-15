<script type="text/javascript">
	$(document).ready(function(){
		/* window onload */
		
		/* 銀行リストボックス変更 */
		$('#btnSend').click(function(){
			var mailSubject = $('#mailSubject').val();
			var mailContents = $('#mailContents').val();
			if(mailContents == ""){
				alert("内容が記述されていません。");
				return;
			}
			$('#btnSend').attr('disabled', 'disabled');
			$('#resultField').html("送信中...");
			$.ajax({url:      '/p/toybox/askpost/'
				  , type:     'post'
				  , data:     {'mailSubject':mailSubject,'mailContents':mailContents}
				  , dataType: 'json'
				  , timeout:  5000
				  , async:    true
				  , error:    function()   { $('#resultField').html('通信エラー'); }
				  , success:  function(res){ setResult(res); }
			});
		});
	});
	
	function setResult(response){
		var msg = response['message'];
		$('#resultField').html(msg);
		$('#btnSend').attr('disabled', '');
	}
	
</script>
<h1 id="subtitle"><span class="subtitle">■</span> お問い合わせ</h1>
<br clear="all" />
<table>
	<tr>
		<td>
			ご意見、ご要望等ございましたら、下のテキストエリアにご記入の上、ご送信ください。<br />
			皆様のお声を参考に、できる範囲で改善して参りたいと思いますので宜しくお願いいたします。<br /><br />
			<input type="hidden" id="mailSubject" value="[honda.net]" />
			<textarea id="mailContents" cols="80" rows="15"></textarea>
		</td>
	</tr>
</table>
<br />
<button id="btnSend">送信</button>
<br /><br />
<div style="color:gray;" id="resultField"></div>