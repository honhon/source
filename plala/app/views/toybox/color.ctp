<script type="text/javascript">
	var step = 16;			//ボタン押下時のカラー値の進み具合
	var colorR = 204;
	var colorG = 204;
	var colorB = 204;
	var strCharList = "0123456789ABCDEF";
	
	$(document).ready(function(){
		/* window onload */
		window.focus();
		setColor();
		
		$('#btnLeftRedAll').click(   function(){ chgColorBar("r", -255); });
		$('#btnLeftGreenAll').click( function(){ chgColorBar("g", -255); });
		$('#btnLeftBlueAll').click(  function(){ chgColorBar("b", -255); });
		$('#btnLeftRed').click(      function(){ chgColorBar("r",   -1); });
		$('#btnLeftGreen').click(    function(){ chgColorBar("g",   -1); });
		$('#btnLeftBlue').click(     function(){ chgColorBar("b",   -1); });
		$('#btnRightRed').click(     function(){ chgColorBar("r",    1); });
		$('#btnRightGreen').click(   function(){ chgColorBar("g",    1); });
		$('#btnRightBlue').click(    function(){ chgColorBar("b",    1); });
		$('#btnRightRedAll').click(  function(){ chgColorBar("r",  255); });
		$('#btnRightGreenAll').click(function(){ chgColorBar("g",  255); });
		$('#btnRightBlueAll').click( function(){ chgColorBar("b",  255); });
		$('#r0').change( function(){ chgColorNumber(); });
		$('#r1').change( function(){ chgColorNumber(); });
		$('#g0').change( function(){ chgColorNumber(); });
		$('#g1').change( function(){ chgColorNumber(); });
		$('#b0').change( function(){ chgColorNumber(); });
		$('#b1').change( function(){ chgColorNumber(); });
		$('#colorName').click( function(){ window.clipboardData.setData("Text", $("#colorName").html()); });
	});

	function setColor(){
		var colorNumber;
		colorNumber = "#" + dec2hex(colorR) + dec2hex(colorG) + dec2hex(colorB);
		$('#r0').val(colorNumber.charAt(1));
		$('#r1').val(colorNumber.charAt(2));
		$('#g0').val(colorNumber.charAt(3));
		$('#g1').val(colorNumber.charAt(4));
		$('#b0').val(colorNumber.charAt(5));
		$('#b1').val(colorNumber.charAt(6));
		$('#colorPalet').css('background-color', colorNumber);
		$('#barR').css('width', (colorR * 100 / 255) + '%');
		$('#barG').css('width', (colorG * 100 / 255) + '%');
		$('#barB').css('width', (colorB * 100 / 255) + '%');
		if(colorR + colorG + colorB < 384){
			$('#colorName').html(colorNumber).css("color","white");
		}else{
			$('#colorName').html(colorNumber).css("color","black");
		}
	}

	//カラーバー変更
	function chgColorBar(strColor, intDiff){
		var diff;
		diff = intDiff * step;
		if(strColor == "r"){
			colorR = fix255(colorR + diff);
		}else if(strColor == "g"){
			colorG = fix255(colorG + diff);
		}else if(strColor == "b"){
			colorB = fix255(colorB + diff);
		}
		setColor();
	}

	//番号変更
	function chgColorNumber(){
		colorR = hex2dec("" + $('#r0').val() + $('#r1').val());
		colorG = hex2dec("" + $('#g0').val() + $('#g1').val());
		colorB = hex2dec("" + $('#b0').val() + $('#b1').val());
		setColor();
	}

	//0-255に丸め
	function fix255(intNum){
		if(intNum > 255){
			return 255;
		}else if(intNum < 0){
			return 0;
		}else{
			return intNum;
		}
	}

	//2桁16進数の変換
	function dec2hex(intNum){
		return strCharList.charAt(Math.floor(intNum / 16)) + strCharList.charAt(intNum % 16);
	}
	function hex2dec(strNum){
		var int10;
		var int1;
		int10 = strCharList.indexOf(strNum.charAt(0));
		int1 = strCharList.indexOf(strNum.charAt(1));
		return (int10 * 16 + int1);
	}
</script>

<h1 id="subtitle"><span class="subtitle">■</span> カラーパレット</h1>
<br clear="all" />
	
<br />
<div id="colorPalet">
<br />
<br />
<table>
	<col style="text-align:right;" />
	<col style="width:150px;" />
	<col style="text-align:left;" />
	<col nowrap />
	<tr>
		<th></th>
		<th nowrap>
			<span id="colorName"></span>
		</th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<td>
			<button id='btnLeftRedAll'> &lt;&lt; </button>
			<button id='btnLeftRed'   > &lt; </button>
		</td>
		<td><hr align="left" style="height:12px;color:#ff0000;background:#ff0000;" id="barR" /></td>
		<td>
			<button id='btnRightRed'   > &gt; </button>
			<button id='btnRightRedAll'> &gt;&gt; </button>
		</td>
		<td nowrap>
			<select id="r0">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
			<select id="r1">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<button id='btnLeftGreenAll'> &lt;&lt; </button>
			<button id='btnLeftGreen'   > &lt; </button>
		</td>
		<td><hr align="left" style="height:12px;color:#00ff00;background:#00ff00;" id="barG" /></td>
		<td>
			<button id='btnRightGreen'   > &gt; </button>
			<button id='btnRightGreenAll'> &gt;&gt; </button>
		</td>
		<td nowrap>
			<select id="g0">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
			<select id="g1">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<button id='btnLeftBlueAll'> &lt;&lt; </button>
			<button id='btnLeftBlue'   > &lt; </button>
		</td>
		<td><hr align="left" style="height:12px;color:#0000ff;background:#0000ff;" id="barB" /></td>
		<td>
			<button id='btnRightBlue'   > &gt; </button>
			<button id='btnRightBlueAll'> &gt;&gt; </button>
		</td>
		<td nowrap>
			<select id="b0">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
			<select id="b1">
				<option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option>
				<option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
				<option value="8">8</option><option value="9">9</option><option value="A">A</option><option value="B">B</option>
				<option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option>
			</select>
		</td>
	</tr>
</table>
<br />
<br />
</div>