var fieldColor  = '#ffffdd';
var helpMessage = '<b>使用方法</b><br /><br />'
				+ '■ カナ で 検索<br />'
				+ '&nbsp;&nbsp;1. 調べたい金融機関の頭文字(カナ)をクリックする。<br />'
				+ '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(対象の「金融機関一覧リストボックス」が表示される)<br /><br />'
				+ '&nbsp;&nbsp;2. 「金融機関一覧リストボックス」から調べたい金融機関を選択する。<br />'
				+ '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(「支店名頭文字で絞込」が表示される)<br /><br />'
				+ '&nbsp;&nbsp;3. 調べたい支店の頭文字を「支店名頭文字で絞込」から選び、クリックする。<br /><br /><br />'
				+ '■ 都市銀行 を 検索<br />'
				+ '&nbsp;&nbsp;1. 都市銀行名をクリックする。(「支店名頭文字で絞込」が表示される)<br /><br />'
				+ '&nbsp;&nbsp;2. 調べたい支店の頭文字を「支店名頭文字で絞込」から選び、クリックする。<br /><br /><br />'
				+ '■ コード で 検索<br />'
				+ '&nbsp;&nbsp;1. 銀行コード(4桁)、支店コード(3桁)を入力し、検索ボタンをクリックする。<br />'
				+ '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(銀行コードの入力は必須)<br />';
var response  = '';

$(document).ready(function(){
	/* window onload */
	init(0);
	
	/* 銀行リストボックス変更 */
	$('#bankList').change(function(){
		if($('#bankList').val() == ''){
			$('#resultField').html('');
			return false;
		}
		doSearchShiten($('#bankList').val(), '');
		$('#condition1kana').show();
	});
	
	/* 銀行・支店コード検索ボタン押下 */
	$('#btnSearch').click(function(){
		init(3);
		if($('#bCode').val().search(/^\d{4}$/) == -1){
			alert('銀行コードは4桁整数を入力してください。');
			$('#bCode').focus();
			$('#bCode').select();
			return false;
		}
		if($('#sCode').val().search(/^\d*$/) == -1){
			alert('支店コードは整数を入力してください。');
			$('#sCode').focus();
			$('#sCode').select();
			return false;
		}
		doSearchShiten($('#bCode').val(), $('#sCode').val());
	});
});

/* 銀行カナリンク押下 */
function searchBank(bankKana){
	init(1);
	$('#resultField').html('検索中...');
	$.ajax({url:      '/p/bank/search/'
		  , type:     'post'
		  , data:     {'act':'bank','bankKana':bankKana}
		  , dataType: 'json'
		  , timeout:  15000
		  , async:    true
		  , error:    function()   { $('#resultField').html('通信エラー'); }
		  , success:  function(res){ setBankList(res); }
	});
}
function setBankList(res){
	if(res['status'] > 0){
		$('#resultField').html('内部エラー: ' + res['status']);
		return false;
	}
	$('#bankList').empty();
	$('#bankList').append('<option value="">▼金融機関名を選択してください</option>');
	for(i = 0; i < res['bankInfo'].length; i++){
		$('#bankList').append('<option value="' + res['bankInfo'][i]['bank_code'] + '">' + res['bankInfo'][i]['bank_name'] + '</option>');
	}
	$('#resultFieldBanklist').show();
	$('#resultField').html('');
}

/* 都市銀行名押下 */
function searchCityBank(code){
	init(2);
	doSearchShiten(code, '');
	$('#condition2kana').show();
}
/* ヘルプリンク押下 */
function help(){
	init(0);
	$('#resultField').html(helpMessage);
}
/* 支店番号リンク押下 */
function showMap(bank_code, shiten_code, seq_no){
	$('#fmapBankCode').val(bank_code);
	$('#fmapShitenCode').val(shiten_code);
	$('#fmapShitenSeq').val(seq_no);
	$('#fmap').submit();
}

function doSearchShiten(bank_code, shiten_code){
	$('#resultField').html('検索中...');
	$.ajax({url:      '/p/bank/search/'
		  , type:     'post'
		  , data:     {'act':'shiten','bankCode':bank_code,'shitenCode':shiten_code}
		  , dataType: 'json'
		  , timeout:  15000
		  , async:    true
		  , error:    function()   { $('#resultField').html('通信エラー'); }
		  , success:  function(res){ setShitenList(res); }
	});
}
function setShitenList(res){
	if(res['status'] > 0){
		$('#resultField').html('内部エラー: ' + res['status']);
		return false;
	}
	response = res;
	searchShitenKana('');
}
function searchShitenKana(shitenKana){
	var outputBank = '';
	var outputShiten = '';
	var bank_code = '';
	var cnt = 0;
	$('#resultField').html('検索中...');
	if(response['bankInfo'].length > 0){
		bank_code = response['bankInfo'][0]['bank_code'];
		outputBank = outputBank + '<div><b>[' + bank_code + '] ' + response['bankInfo'][0]['bank_name'] + ' ( ' + response['bankInfo'][0]['bank_kana'] + ' )</b></div><br />';
	}
	if(response['shitenInfo'].length > 0){
		outputShiten = outputShiten + '<table class="bank"><col /><col style="width:200px;" /><col style="width:160px;" />'
		                + '<tr><th style="width:80px">支店コード</th><th>支店名</th><th>支店名カナ</th></tr>';
		for(i = 0; i < response['shitenInfo'].length; i++){
			var s_code =  response['shitenInfo'][i]['shiten_code'];
			var s_seqno = response['shitenInfo'][i]['seq_no'];
			var s_name =  response['shitenInfo'][i]['shiten_name'];
			var s_kana =  response['shitenInfo'][i]['shiten_kana'];
			if(shitenKana == '' || shitenKana == s_kana.substr(0,1)){
				outputShiten = outputShiten
				                + '<tr>'
				                + '<th>' + s_code + '</th>'
				                + '<td>' + s_name + '</td>'
				                + '<td>' + s_kana + '</td>'
				                + '</tr>';
				cnt = cnt + 1;
//+ '<td><a href="javascript:showMap(\'' + bank_code + '\',\'' + s_code + '\',' + s_seqno + ')">' + s_code + '</a></td>'
			}
		}
		outputShiten = outputShiten + '</table>';
	}
	if(cnt == 0){
		outputShiten = '<span style="color:red;">合致するデータが見つかりませんでした。</span>';
	}
	$('#resultField').hide();
	$('#resultField').html(outputBank + outputShiten);
	$('#resultField').fadeIn('slow');
}

function init($condition){
	$('#resultFieldBanklist').hide();
	$('#resultField').html('');
	$('#condition1').css('background-color', '');
	$('#condition2').css('background-color', '');
	$('#condition3').css('background-color', '');
	$('#condition1kana').hide();
	$('#condition2kana').hide();
	
	switch($condition){
		case 1 :
			$('#condition1').css('background-color', fieldColor);
			break;
		case 2 :
			$('#condition2').css('background-color', fieldColor);
			break;
		case 3 :
			$('#condition3').css('background-color', fieldColor);
			break;
	}
}
