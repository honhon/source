<script type="text/javascript">
	$(document).ready(function(){
		/* window onload */
		
		$('#btnCalc').click(function(){
			var ip1, ip2, ip3, ip4, mask, i, strRet;
			var strN, strB, ipAddress, maskAddress, networkAddress, broadcastAddress;
			
			$("#idNet").html("");
			$("#idBroadcast").html("");
			$("#idRange").html("");
			$("#idIp").html("");
			
			for(i = 1; i <= 4; i++){
				if(!chkIp($("#idIp" + i))){
					return;
				}
			}
			ip1 = parseInt($("#idIp1").val(), 10);
			ip2 = parseInt($("#idIp2").val(), 10);
			ip3 = parseInt($("#idIp3").val(), 10);
			ip4 = parseInt($("#idIp4").val(), 10);
			mask = parseInt($("#idMask").val(), 10);
			
			strN = "";
			strB = "";
			for(i = 0; i < 32 - mask; i++){
				strN = strN + "0";
				strB = strB + "1";
			}
			
			ipAddress = "" + dec2bit(ip1) + dec2bit(ip2) + dec2bit(ip3) + dec2bit(ip4);
			maskAddress = strN;
			for(i = 0; i < mask; i++){
				maskAddress = "1" + maskAddress;
			}
			networkAddress = ipAddress.substr(0, mask) + strN;
			broadcastAddress = ipAddress.substr(0, mask) + strB;
			
			$("#idNet").html(
					  bit2dec(networkAddress.substr(0, 8)) + "."
					+ bit2dec(networkAddress.substr(8, 8)) + "."
					+ bit2dec(networkAddress.substr(16, 8)) + "."
					+ bit2dec(networkAddress.substr(24, 8)));
			$("#idBroadcast").html(
					  bit2dec(broadcastAddress.substr(0, 8)) + "."
					+ bit2dec(broadcastAddress.substr(8, 8)) + "."
					+ bit2dec(broadcastAddress.substr(16, 8)) + "."
					+ bit2dec(broadcastAddress.substr(24, 8)));
			$("#idRange").html(
					  bit2dec(networkAddress.substr(0, 8)) + "."
					+ bit2dec(networkAddress.substr(8, 8)) + "."
					+ bit2dec(networkAddress.substr(16, 8)) + "."
					+ bit2dec(networkAddress.substr(24, 7) + "1")
					+ " ～ "
					+ bit2dec(broadcastAddress.substr(0, 8)) + "."
					+ bit2dec(broadcastAddress.substr(8, 8)) + "."
					+ bit2dec(broadcastAddress.substr(16, 8)) + "."
					+ bit2dec(broadcastAddress.substr(24, 7) + "0"));
			$("#idIp").html(
					  "[ "
					+ bit2dec(networkAddress.substr(0, 8)) + "."
					+ bit2dec(networkAddress.substr(8, 8)) + "."
					+ bit2dec(networkAddress.substr(16, 8)) + "."
					+ bit2dec(networkAddress.substr(24, 8))
					+ " / "
					+ bit2dec(maskAddress.substr(0, 8)) + "."
					+ bit2dec(maskAddress.substr(8, 8)) + "."
					+ bit2dec(maskAddress.substr(16, 8)) + "."
					+ bit2dec(maskAddress.substr(24, 8))
					+ " ]");
		});
	});

	function chkIp(objIp){
		if(objIp.val().search(/^\d+$/) == -1){
			alert("数値を入力してください。");
			objIp.focus();
			objIp.select();
			return false;
		}
		if(objIp.val() > 255){
			alert("255以下の数値を入力してください。");
			objIp.focus();
			objIp.select();
			return false;
		}
		return true;
	}
	function dec2bit(intNum){
		var strBit = "";
		var intTmp = intNum;
		for(i = 7; i >= 0; i--){
			if(intTmp >= Math.pow(2, i)){
				strBit = strBit + "1";
				intTmp = intTmp - Math.pow(2, i);
			}else{
				strBit = strBit + "0";
			}
		}
		return strBit;
	}
	function bit2dec(strBitList){
		var ret = 0;
		for(i = 0; i < strBitList.length; i++){
			if(strBitList.substr(i, 1) != "0"){
				ret = ret + Math.pow(2, strBitList.length - 1 - i);
			}
		}
		return ret;
	}
</script>

<center>
<h1 id="subtitle"><span class="subtitle">■</span> IP計算機</h1>
<br clear="all" />
<br />
<table>
<tr>
	<th class="left">IP:</th>
	<td colspan="2">
		<input type="text" id="idIp1" size="3" maxlength="3" /> .
		<input type="text" id="idIp2" size="3" maxlength="3" /> .
		<input type="text" id="idIp3" size="3" maxlength="3" /> .
		<input type="text" id="idIp4" size="3" maxlength="3" />
	</td>
</tr>
<tr>
	<th class="left">MASK:</th>
	<td>
		<select id="idMask">
			<option value="30">30</option><option value="29">29</option><option value="28" selected>28</option><option value="27">27</option><option value="26">26</option>
			<option value="25">25</option><option value="24">24</option><option value="23">23</option><option value="22">22</option><option value="21">21</option>
			<option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option>
			<option value="15">15</option><option value="14">14</option><option value="13">13</option><option value="12">12</option><option value="11">11</option>
			<option value="10">10</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
			<option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
		</select>
	</td>
	<td class="right"><button id="btnCalc">calc</button></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<th class="left">Network: </th>
	<td id="idNet" colspan="2"></td>
</tr>
<tr>
	<th class="left">BroadCast: </th>
	<td id="idBroadcast" colspan="2"></td>
</tr>
<tr>
	<th class="left">Available IP: </th>
	<td id="idRange" colspan="2"></td>
</tr>
<tr>
	<td id="idIp" colspan="3" class="center"></td>
</tr>
</table>
</center>