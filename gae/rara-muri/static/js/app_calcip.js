$(function(){
    var chkIp = function(objIp){
        if(objIp.val().search(/^\d+$/) == -1){
            $('#result').html('<div class="alert alert-danger">数値を入力してください</div>');
            objIp.focus();
            objIp.select();
            return false;
        }
        if(objIp.val() > 255){
            $('#result').html('<div class="alert alert-danger">255以下の数値を入力してください</div>');
            objIp.focus();
            objIp.select();
            return false;
        }
        return true;
    };
    var dec2bit = function(intNum){
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
    };
    var bit2dec = function(strBitList){
        var ret = 0;
        for(i = 0; i < strBitList.length; i++){
            if(strBitList.substr(i, 1) != "0"){
                ret = ret + Math.pow(2, strBitList.length - 1 - i);
            }
        }
        return ret;
    };

    $('#btnCalc').click(function(){
        var ip1, ip2, ip3, ip4, mask, i, strRet;
        var strN, strB, ipAddress, maskAddress, networkAddress, broadcastAddress;
        $("#result").html("");
        for(i = 1; i <= 4; i++){
            if(!chkIp($("#ip" + i))){
                return;
            }
        }
        ip1 = parseInt($("#ip1").val(), 10);
        ip2 = parseInt($("#ip2").val(), 10);
        ip3 = parseInt($("#ip3").val(), 10);
        ip4 = parseInt($("#ip4").val(), 10);
        mask = parseInt($("#mask").val(), 10);

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

        $("#result").html('<div class="well"><table>'
                + "<tr><th>NETWORK IP: </th><td>"
                + bit2dec(networkAddress.substr(0, 8)) + "."
                + bit2dec(networkAddress.substr(8, 8)) + "."
                + bit2dec(networkAddress.substr(16, 8)) + "."
                + bit2dec(networkAddress.substr(24, 8))
                + "</td><tr>"
                + "<tr><th>BROADCAST IP: </th><td>"
                + bit2dec(broadcastAddress.substr(0, 8)) + "."
                + bit2dec(broadcastAddress.substr(8, 8)) + "."
                + bit2dec(broadcastAddress.substr(16, 8)) + "."
                + bit2dec(broadcastAddress.substr(24, 8))
                + "</td><tr>"
                + "<tr><th>IP RANGE: </th><td>"
                + bit2dec(networkAddress.substr(0, 8)) + "."
                + bit2dec(networkAddress.substr(8, 8)) + "."
                + bit2dec(networkAddress.substr(16, 8)) + "."
                + bit2dec(networkAddress.substr(24, 7) + "1") + " ～ "
                + bit2dec(broadcastAddress.substr(0, 8)) + "."
                + bit2dec(broadcastAddress.substr(8, 8)) + "."
                + bit2dec(broadcastAddress.substr(16, 8)) + "."
                + bit2dec(broadcastAddress.substr(24, 7) + "0")
                + "</td><tr>"
                + "<tr><th></th><td>"
                + "[ "
                + bit2dec(networkAddress.substr(0, 8)) + "."
                + bit2dec(networkAddress.substr(8, 8)) + "."
                + bit2dec(networkAddress.substr(16, 8)) + "."
                + bit2dec(networkAddress.substr(24, 8))
                + " / "
                + bit2dec(maskAddress.substr(0, 8)) + "."
                + bit2dec(maskAddress.substr(8, 8)) + "."
                + bit2dec(maskAddress.substr(16, 8)) + "."
                + bit2dec(maskAddress.substr(24, 8))
                + " ]"
                + "</td></tr></table></div>");
    });

});
