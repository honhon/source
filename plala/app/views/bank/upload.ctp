<div style="color:red;"><?php if(isset($errMsg) && $errMsg != null){ echo $errMsg;} ?></div>
<div style="color:blue;"><?php if(isset($msg) && $msg != null){ echo $msg;} ?></div>
<br />
BANK
<br />
<form name="f" method="post" enctype="multipart/form-data" action="/p/bank/upload/">
	<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
	<input type="file" name="bank1" size="100" /><br />
	<input type="file" name="bank2" size="100" /><br />
	<input type="file" name="bank3" size="100" /><br />
	<input type="file" name="bank4" size="100" /><br />
	<button onClick="javascript:this.disabled=true;document.f.submit();">アップロード</button>
</form>
<br>
