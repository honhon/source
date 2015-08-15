<style type='text/css'>
	table.res th {background-color:#aaddcc; padding:0px 5px; }
	table.res td {background-color:#eafafa; padding:0px 5px; text-align:left; }
</style>
<h1 id="subtitle"><span class="subtitle">■</span> DB検索</h1>
<br clear="all" />

<div style='background-color:#dddddd;'>
	<select id='dbType'>
		<option value=''></option>
		<option value='mysql'>MySQL</option>
		<option value='pgsql'>PostgreSQL</option>
	</select>&nbsp;
	ホスト(IP): <input type='text'     id='dbHost' size='15'>&nbsp;
	DB名:       <input type='text'     id='dbName' size='10'>&nbsp;
	ポート:     <input type='text'     id='dbPort' size='5'>&nbsp;
	user:       <input type='text'     id='dbUser' size='10'>&nbsp;
	password:   <input type='password' id='dbPass' size='10'>&nbsp;
	<button id='btnConn'>接続</button>
</div>
<div id='blockCondition'>
	<fieldset style='width:650px;'>
	<legend>
		<input type='radio' name='menu' id='radioMenu1' checked><label for='radioMenu1'>type Ⅰ</label>
		<input type='radio' name='menu' id='radioMenu2'        ><label for='radioMenu2'>type Ⅱ</label>
	</legend>
	<table id='blockCondition1'>
	<tr>
		<td>SELECT</td>
		<td><input type='text' id='sqlcol' value='*' size='80'></td>
	</tr>
	<tr>
		<td>FROM</td>
		<td>
			<select id='selectTable'></select>
<!--		<button id='btnSearchTable'>.</button> //-->
		</td>
	</tr>
	<tr>
		<td>WHERE</td>
		<td><input type='text' id='sqlwhere' size='80'></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type='text' id='sqletc' value='limit 30' size='80'>&nbsp;&nbsp;
			<button id='btnSearch1'>検索</button>
		</td>
	</tr>
	</table>
	<table id='blockCondition2'>
	<tr>
		<td>
			<textarea id='sqlText' rows='6' cols='90'></textarea>&nbsp;&nbsp;
			<button id='btnSearch2'>検索</button>
		</td>
	</tr>
	</table>
	</fieldset>
</div>
<br />
<div id='blockErrorMessage' style='color:red;'></div>
<div id='blockInfoMessage' style='color:blue;'></div>
<div id='blockResult' style='height:250px;overflow:auto;'></div>
<script type='text/javascript'>
	var strDbType, strDbHost, strDbName, strDbPort, strDbUser, strDbPass;
	
	$(document).ready(function(){
		/* window onload */
		init();
		var cook = getCookie('dbtool');
		if(cook != null && cook != ''){
			var ary = cook.split('/');
			if(ary.length >= 5){
				$('#dbType').val(ary[0]);
				$('#dbHost').val(ary[1]);
				$('#dbName').val(ary[2]);
				$('#dbPort').val(ary[3]);
				$('#dbUser').val(ary[4]);
			}
		}
		$('#blockCondition1').show();
		$('#blockCondition2').hide();
		$('#blockCondition').hide();
		
		$('#btnConn').click(function(){
			connect();
		});
		$('#btnSearch1').click(function(){
			var sql = 'select ' + $('#sqlcol').val() + ' from ' + $('#selectTable').val();
			sql = sql + ($('#sqlwhere').val() == ''? ' ': ' whrere ');
			sql = sql + $('#sqlwhere').val() + ' ' + $('#sqletc').val();
			search(sql);
		});
		$('#btnSearch2').click(function(){
			var sql = jQuery.trim($('#sqlText').val());
			search(sql);
		});
		$('#btnSearchTable').click(function(){
			var sql = getDefSql();
			search(sql);
		});
		$('#dbType').change(function(){ init(); });
		$('#dbHost').change(function(){ init(); });
		$('#dbName').change(function(){ init(); });
		$('#dbPort').change(function(){ init(); });
		$('#dbUser').change(function(){ init(); });
		$('#dbPass').change(function(){ init(); });
		$('#radioMenu1').click(function(){ $('#blockCondition1').show(); $('#blockCondition2').hide(); });
		$('#radioMenu2').click(function(){ $('#blockCondition1').hide(); $('#blockCondition2').show(); });
	});
	
	function init(){
		$('#blockCondition').hide();
		$('button').attr('disabled','');
		clear();
	}
	function clear(){
		$('#blockResult').html('');
		$('#blockInfoMessage').html('');
		$('#blockErrorMessage').html('');
	}
	function connect(){
		strDbType = jQuery.trim($('#dbType').val());
		strDbHost = jQuery.trim($('#dbHost').val());
		strDbName = jQuery.trim($('#dbName').val());
		strDbPort = jQuery.trim($('#dbPort').val());
		strDbUser = jQuery.trim($('#dbUser').val());
		strDbPass = jQuery.trim($('#dbPass').val());
		if(strDbType == ''){alert('DBを選択してください');         $('#dbType').focus(); $('#dbType').select(); return false; }
		if(strDbHost == ''){alert('ホスト名を入力しtください');    $('#dbHost').focus(); $('#dbHost').select(); return false; }
		if(strDbName == ''){alert('DB名を入力してください');       $('#dbName').focus(); $('#dbName').select(); return false; }
		if(strDbPort == ''){alert('ポートを入力してください');     $('#dbport').focus(); $('#dbPort').select(); return false; }
		if(strDbUser == ''){alert('ユーザを入力してください');     $('#dbUser').focus(); $('#dbUser').select(); return false; }
		if(strDbPass == ''){alert('パスワードを入力してください'); $('#dbPass').focus(); $('#dbPass').select(); return false; }
		init();
		$('#blockInfoMessage').html('DB接続中...');
		$('#btnConn').attr('disabled','disabled');
		$.ajax({url:      '/p/dbtool/query/'
			  , type:     'post'
			  , data:     {'act':'table','dbType':strDbType,'dbHost':strDbHost,'dbName':strDbName,'dbPort':strDbPort,'dbUser':strDbUser,'dbPass':strDbPass}
			  , dataType: 'json'
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { clear(); $('#blockErrorMessage').html('通信エラー'); $('#btnConn').attr('disabled',''); }
			  , success:  function(res){ clear(); setTableList(res); }
		});
	}
	function setTableList(res){
		if(res['status'] == 'ok' && res['type'] == 'table'){
			$('#selectTable').empty();
			for(var i = 0; i < res['data'].length; i++){
				$('#selectTable').append('<option>' + res['data'][i] + '</option>');
			}
			$('#blockCondition').show();
			setCookie('dbtool', $('#dbType').val() + '/' + $('#dbHost').val() + '/' + $('#dbName').val() + '/' + $('#dbPort').val() + '/' + $('#dbUser').val(), 7);
		}else{
			var err = res['error']? res['error']: 'DB接続失敗';
			err = err + 'status=' +res['status'] + 'type=' +res['type'] + 'res=' +res;
			$('#blockErrorMessage').html(err);
		}
	}
	
	function search(sql){
		clear();
		$('#blockInfoMessage').html('DB接続中...');
		$('button').attr('disabled','disabled');
		$.ajax({url:      '/p/dbtool/query/'
			  , type:     'post'
			  , data:     {'act':'sql','dbType':strDbType,'dbHost':strDbHost,'dbName':strDbName,'dbPort':strDbPort,'dbUser':strDbUser,'dbPass':strDbPass,'sql':sql}
			  , dataType: 'json'
			  , timeout:  10000
			  , async:    true
			  , error:    function()   { clear(); $('#blockErrorMessage').html('通信エラー'); $('button:not(:first)').attr('disabled',''); }
			  , success:  function(res){ clear(); setResult(res); $('button:not(:first)').attr('disabled',''); }
		});
	}
	function setResult(res){
		var msg =    (res['message'])? res['message']: '';
		var error =  (res['error'])?   res['error']:   '';
		var result = '';
		if(res['data']){
			result = result + '<table class="res">';
			if(res['header']){
				result = result + '<tr>';
				for(var i = 0; i < res['header'].length; i++){
					result = result + '<th>' + res['header'][i] + '</th>';
				}
				result = result + '</tr>';
			}
			for(var i = 0; i < res['data'].length; i++){
				result = result + '<tr>';
				for(var j = 0; j < res['data'][i].length; j++){
					result = result + '<td>' + (res['data'][i][j] == null? '<span style="color:silver;">null</span>': res['data'][i][j]) + '</td>';
				}
				result = result + '</tr>';
			}
			result = result + '</table>';
			if(res['sql']){
				result = result + '<div style"color:gray;font-weight:bold;">' + res['sql'] + '</div>';
			}
		}
		$('#blockInfoMessage').html(msg);
		$('#blockErrorMessage').html(error);
		$('#blockResult').hide();
		$('#blockResult').html(result);
		$('#blockResult').fadeIn('slow');
	}
	function setCookie(myCookie, myValue, myDay){
		var myExp = new Date();
		myExp.setTime(myExp.getTime() + (myDay*24*60*60*1000));
		var myItem = '@' + myCookie + '=' + escape(myValue) + ';';
		var myExpires = 'expires=' + myExp.toGMTString();
		document.cookie = myItem + myExpires;
	}
	function getCookie(myCookie){
		var myCookie = '@' + myCookie + '=';
		var myValue = null;
		var myStr = document.cookie + ';';
		var myOfst = myStr.indexOf(myCookie);
		if(myOfst != -1){
			var myStart = myOfst + myCookie.length;
			var myEnd = myStr.indexOf(';', myStart);
			myValue = unescape(myStr.substring(myStart, myEnd));
		}
		return myValue;
	}
	function getDefSql(){
		//Oracle
		if(strDbType == "oci8"){
			return "SELECT COLUMN_NAME COL, DATA_TYPE TYPE, DATA_LENGTH LEN, NULLABLE NUL, DATA_DEFAULT DEF, DATA_PRECISION PRE, DATA_SCALE SCALE "
				+ " FROM ALL_TAB_COLUMNS "
				+ " WHERE OWNER = '" + strDbUser.toUpperCase() + "'"
				+ " AND TABLE_NAME='" + $('#selectTable').val() + "' ORDER BY COLUMN_ID";
		//Postgres
		}else if(strDbType == "pgsql"){
			return "SELECT PG_ATTRIBUTE.ATTNAME AS COL, "
				+ " PG_TYPE.TYPNAME AS TYPE,"
				+ " CASE WHEN PG_TYPE.TYPLEN > 0 THEN PG_TYPE.TYPLEN"
				+ "  ELSE"
				+ "   CASE PG_TYPE.TYPNAME"
				+ "   WHEN 'bpchar' THEN PG_ATTRIBUTE.ATTTYPMOD - 4"
				+ "   WHEN 'varchar' THEN PG_ATTRIBUTE.ATTTYPMOD - 4"
				+ "   WHEN 'numeric' THEN (PG_ATTRIBUTE.ATTTYPMOD - 4) / 65536"
				+ "   WHEN 'decimal' THEN (PG_ATTRIBUTE.ATTTYPMOD - 4) / 65536"
				+ "  ELSE 0"
				+ "  END"
				+ " END AS SIZE,"
				+ " PG_ATTRIBUTE.ATTNOTNULL AS NUL "
				+ " FROM PG_CLASS "
				+ " INNER JOIN PG_ATTRIBUTE ON PG_CLASS.OID = PG_ATTRIBUTE.ATTRELID "
				+ " INNER JOIN PG_TYPE ON PG_ATTRIBUTE.ATTTYPID = PG_TYPE.OID "
				+ " WHERE  PG_ATTRIBUTE.ATTNUM > 0 "
				+ " AND PG_CLASS.RELNAME = '" + $('#selectTable').val() + "'"
				+ " ORDER BY PG_ATTRIBUTE.ATTNUM ";
		//MySql
		}else if(strDbType == "mysql"){
			return "show fields from " + $('#selectTable').val();
		}
		return "";
	}
</script>