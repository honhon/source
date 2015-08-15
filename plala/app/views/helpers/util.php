<?php
class UtilHelper extends AppHelper {
	function postformat($str) {
		if(strlen($str) <= 3){
			return $str;
		}
		return substr($str, 0, 3) . '-' . substr($str, 3);
	}
}
?>