<?php
class RequestComponent {
	private $param = array();
	private $cookie = array();

	public function startup(&$controller) {
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		$param = ($method == 'POST')? $_POST: $_GET;
		$this->param = self::removeCtrlCode($param);
		$this->cookie = self::removeCtrlCode($_COOKIE);
	}

	private static function removeCtrlCode($ary){
                return $ary;
		/*
                $ret = array();
		foreach($ary as $k => $v){
			$ret[$k] = preg_replace('/[x00-x1f]/', '', $v);
		}
		return $ret;
                */
	}

	public function getParam($key, $def=false){
		if(!isset($this->param[$key])){
			return $def;
		}
		return $this->param[$key];
	}

	public function getCookie($key, $def=false){
		if(!isset($this->cookie[$key])){
			return $def;
		}
		return $this->cookie[$key];
	}
	
	public function isPost(){
		return (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST');
	}

	public function isGet(){
		return (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET');
	}
}
?>
