var fieldColor  = '#ffffdd';

function init($condition){
	$('#resultFieldCityList').hide();
	$('#resultField').html('');
	$('#condition1').css('background-color', '');
	$('#condition2').css('background-color', '');	
	switch($condition){
		case 1 :
			$('#condition1').css('background-color', fieldColor);
			break;
		case 2 :
			$('#condition2').css('background-color', fieldColor);
			break;
	}
}

$(document).ready(function(){
	/* window onload */
	init(0);
	
	/* 都市リストボックス変更 */
	$('#cityList').change(function(){
		var city_code = $('#cityList').val();
		if(city_code == ''){
			$('#resultField').html('');
			return;
		}
		
		$('#resultField').html('検索中...');
		$.ajax({url:      '/p/post/search/'
			  , type:     'post'
			  , data:     {'act':'post','cityCode': city_code}
			  , dataType: 'json'
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { $('#resultField').html('通信エラー'); }
			  , success:  function(res){ dispResult(res); }
		});
	});
	
	/* ポストコード検索ボタン押下 */
	$('#btnSearch').click(function(){
		init(2);
		var postCode = '' + $('#pCode1').val() + $('#pCode2').val();
		if($('#pCode1').val().search(/^\d{3}$/) == -1){
			alert('3桁整数を入力してください。');
			$('#pCode1').focus();
			$('#pCode1').select();
			return false;
		}
		if($('#pCode2').val().search(/^\d{0,4}$/) == -1){
			alert('整数を入力してください。(最大4桁)');
			$('#pCode2').focus();
			$('#pCode2').select();
			return false;
		}
		
		$('#resultField').html('検索中...');
		$.ajax({url:      '/p/post/search/'
			  , type:     'post'
			  , data:     {'act':'post','postCode':postCode}
			  , dataType: 'json'
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { $('#resultField').html('通信エラー'); }
			  , success:  function(res){ dispResult(res); }
		});
	});
});
/* 都市検索 */
function searchCity(code){
	init(1);
	$('#resultField').html('検索中...');
	$.ajax({url:      '/p/post/search/'
		  , type:     'post'
		  , data:     {'act':'city','kenCode':code}
		  , dataType: 'json'
		  , timeout:  10000
		  , async:    true
		  , error:    function()   { $('#resultField').html('通信エラー'); }
		  , success:  function(res){ setCityList(res); }
	});
}
function setCityList(res){
	if(res['status'] > 0){
		$('#resultField').html('内部エラー: ' + res['status']);
		return false;
	}
	$('#cityList').empty();
	$('#cityList').append('<option value="">▼市町村を選択してください</option>');
	for(i = 0; i < res['city'].length; i++){
		$('#cityList').append('<option value="' + res['city'][i]['code'] + '">' + res['city'][i]['name'] + '</option>');
	}
	$('#resultFieldCityList').show();
	$('#resultField').html('');
}

function dispResult(response){
	if(response['status'] > 0){
		$('#resultField').html('内部エラー' + response['status']);
		return false;
	}
	
	output = '';
	var cnt = response['post'].length;
	if(cnt == 0){
		output =  '<span style="color:red;">合致するデータが見つかりませんでした。</span>';
	}else{
		output = output + '<table class="bank"><col style="width:60px;" nowrap /><col style="width:240px;" /><col />'
		                + '<tr><th>郵便番号</th><th>住所</th><th>カナ</th></tr>';
		for(i = 0; i < cnt; i++){			
			var code     = response['post'][i]['post_code'];
			var address  = response['post'][i]['ken_name'] + response['post'][i]['city_name'] + response['post'][i]['post_name'];
			var kana     = response['post'][i]['ken_kana'] + response['post'][i]['city_kana'] + response['post'][i]['post_kana'];
			var address2 = address;
			var post_code = code.substr(0, 3) + '-' + code.substr(3);
			if(address.indexOf("以下に") > 0){
				address2 = address.substring(0, address.indexOf("以下に"));
			}else if(address.indexOf("（") > 0){
				address2 = address.substring(0, address.indexOf("（"));
			}
			output = output + "<tr><td><a href='javascript:showMap(\"" + address2 + "\")'>" + post_code + "</a></td><td>" + address + "</td><td>" + kana + "</td></tr>";
		}
		output = output + '</table>';
	}
	$('#resultField').hide();
	$('#resultField').html(output);
	$('#resultField').fadeIn('slow');
}

function showMap(name){
	document.fmap.q.value = name;
	document.fmap.target = "_blank";
	document.fmap.method = "get";
	document.fmap.action = "http://local.google.co.jp/local";
	document.fmap.submit();
}
