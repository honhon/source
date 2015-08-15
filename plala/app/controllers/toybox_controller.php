<?php
class ToyboxController extends AppController {
	var $uses = array();
	
	public function ip() {
		$title = 'ip計算機';
		$meta_keywords = 'ip,計算機,ip計算機,ネットワークアドレス';
		$meta_description = 'ipアドレスとネットマスクから、そのipの属するネットワーク内のipアドレスレンジを求めます。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function color() {
		$title = 'カラーパレット';
		$meta_keywords = 'カラー,パレット';
		$meta_description = '16進数のRGB値の色を表示します。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function amazon() {
		$act = isset($_POST['act'])? $_POST['act']: '';
		if($act == 'search'){
			$server = 'ecs.amazonaws.jp';
			$port = 80;
			$timeout = 10;
			$path = '/onca/xml';
			$secret = 'uQqxZF/NAnroZz4fAMJylFchKH40yuG6K3cAUj3b';
			$param = array();
			$param['Service']        = 'AWSECommerceService';
			$param['AWSAccessKeyId'] = '1S7XVJD56WM161X3D0R2';
			$param['Timestamp']      = date('Y-m-d\TH:i:s\Z');
			$param['Operation']      = isset($_POST['Operation'])?     $_POST['Operation']:     '';
			$param['SearchIndex']    = isset($_POST['SearchIndex'])?   $_POST['SearchIndex']:   '';
			$param['ResponseGroup']  = isset($_POST['ResponseGroup'])? $_POST['ResponseGroup']: '';
			$param['Sort']           = isset($_POST['Sort'])?          $_POST['Sort']:          '';
			$param['Title']          = isset($_POST['Title'])?         $_POST['Title']:         '';
			$param['Author']         = isset($_POST['Author'])?        $_POST['Author']:        '';
			$param['Keywords']       = isset($_POST['Keywords'])?      $_POST['Keywords']:      '';
			ksort($param);
			$param_str = '';
			foreach($param as $k => $v){
				$param_str .= ($param_str === '')? '': '&';
				$param_str .= $k . '=' . rawurlencode($v);
			}
			$sign_seed = "GET\n$server\n$path\n$param_str";
			$param_str .= '&Signature=' . rawurlencode(base64_encode(hash_hmac('sha256', $sign_seed, $secret, true)));

			$url = 'http://' . $server . $path . '?' . $param_str;
echo $url;
exit;
			$header  = 'GET ' . $url . ' HTTP/1.1' . "\r\n";
			$header .= 'Host: ' . $server . "\r\n";
			$header .= 'Connection: Close' . "\r\n\r\n";
			$fp = fsockopen($server, $port, $errno, $errstr, $timeout);
			if (!$fp) { echo $errstr . '(' . $errno . ')<br />'; exit; }
			fwrite($fp, $header);
			$response = '';
			while (!feof($fp)) { $response .= fgets($fp, 4096); }
			fclose($fp);
			$ary_res = explode("\r\n\r\n", $response, 2);
			echo(isset($ary_res[1])? $ary_res[1]: '');
			exit;
		}
		
		$title = 'amazon';
		$meta_keywords = 'amazon,api,xml';
		$meta_description = 'アマゾンのwebapiを使って、条件にあった商品情報を表示します。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function env() {
		$title = '環境変数';
		$meta_keywords = '環境変数';
		$meta_description = 'お使いのクライアントから渡される環境変数の一部を表示します。';
		$list = array();
		$searchList = array('HTTP', 'REQUEST', 'REMOTE');
		foreach($_SERVER as $k => $v){
			$header = explode('_', $k);
			if(in_array($header[0], $searchList)){
				$list[$k] = $v;
			}
		}
		$this->set(compact('title', 'list', 'meta_keywords', 'meta_description'));
	}
	public function googlemaps() {
		$title = 'Google maps API ドキュメント';
		$meta_keywords = 'google,maps,api';
		$meta_description = 'Google maps api';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function encode() {
		$act         = isset($_POST['act'])?         $_POST['act']:         '';
		$source      = isset($_POST['source'])?      $_POST['source']:      '';
		$charsettype = isset($_POST['charsettype'])? $_POST['charsettype']: '';
		if($act == ''){
			$title = 'url encode';
			$meta_keywords = 'url,encode,decode,エンコード,デコード,base64,md5';
			$meta_description = 'urlエンコード、base64、md5の変換処理を実行します。md5以外はデコード処理も実装しています。';
			$this->set(compact('title', 'meta_keywords', 'meta_description'));
		}else{
			$s = $source;
			switch($charsettype){
				case '1':	$s = mb_convert_encoding($source, 'EUC-JP', 'UTF-8'); break;
				case '2':	$s = mb_convert_encoding($source, 'SJIS',   'UTF-8'); break;
			}
			
			$dest = ''; 
			switch($act){
				case '1':	$dest = urlencode($s); break;
				case '2':	$dest = urldecode($s); break;
				case '3':	$dest = base64_encode($s); break;
				case '4':	$dest = base64_decode($s); break;
				case '5':	$dest = md5($s); break;
			}
			
			$d = $dest;
			switch($charsettype){
				case '1':	$d = mb_convert_encoding($dest, 'UTF-8', 'EUC-JP'); break;
				case '2':	$d = mb_convert_encoding($dest, 'UTF-8', 'SJIS'); break;
			}
			echo $d;
			exit;
		}
	}

	public function ask() {
		$title = 'お問い合わせ';
		$meta_keywords = 'お問い合わせ';
		$meta_description = 'ご意見、ご要望等ございましたら、こちらのフォームより投稿お願いいたします。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function askpost() {
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$message = '';
		if (count($_POST) > 0){
			$subject  = mb_convert_encoding($_POST['mailSubject'],  'ISO-2022-JP', 'UTF-8');
			$contents = mb_convert_encoding($_POST['mailContents'], 'ISO-2022-JP', 'UTF-8');
			$to = 'hondat@beige.plala.or.jp';
			$res = mail($to, $subject, $contents);
			$message = ($res)? '送信しました。': '送信失敗しました。'. $res;
		}
		$data = array('message' => $message);
		$this->set(compact('data'));
		$this->render('jsondata');
	}
}
?>
