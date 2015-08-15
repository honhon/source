<?php
class MobilePostController extends AppController {
	var $components = array('MobileFilter');
	var $uses = array('Post');
	var $helpers = array('Util');
	var $layout = 'mobile';
	
	var $header_title     = '郵便番号検索[モバイル版]';
	var $meta_keywords    = '郵便番号,検索,本田郵便局,モバイル端末';
	var $meta_description = '本田郵便局では郵便番号が簡単に調べられます。市町村、または、郵便コードからお探しの情報が検索できます。モバイル端末にも対応しています。';

	public function beforeFilter(){
		$title            = $this->header_title;
		$meta_keywords    = $this->meta_keywords;
		$meta_description = $this->meta_description;
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	
	public function index() {
		$ken = $this->Post->getKenAll();
		$this->set(compact('ken'));
	}
	
	public function search(){
		try{
			$pass      = $this->params['pass'];
			$act       = (isset($pass[0]))? $pass[0]: '';
			$param     = (isset($pass[1]))? $pass[1]: '';
			$post_code = $this->request->getParam('postcode', '');
			
			$subject          = '';
			$meta_keywords    = $this->meta_keywords;
			$meta_description = $this->meta_description;
			$msg = '';
			$city = array();
			$post = array();
			
			if($act == 'city' && (preg_match('/^\d+$/', $param) == 1)){
				$ken_code = $param;
				$ken_name = $this->Post->getKenName($ken_code);
				$city = $this->Post->getCity($ken_code);
				$subject          .= $ken_name;
				$meta_keywords    .= ',' . $ken_name;
				$meta_description  = '[ ' . $ken_name . ' ]' . $meta_description;
			}elseif($act == 'post' && (preg_match('/^\d+$/', $param) == 1)){
				$city_code = $param;
				$post = $this->Post->getPostByCityCode($city_code);
				if(isset($post[0])){
					$subject          .= $post[0]['ken_name'] . $post[0]['city_name'];
					$meta_keywords    .= ',' . $post[0]['ken_name'] . $post[0]['city_name'];
					$meta_description  = '[ ' . $post[0]['ken_name'] . $post[0]['city_name'] . ' ]' . $meta_description;
				}
			}elseif($post_code != ''){
				if(preg_match('/^\d+$/', $post_code) != 1 || strlen($post_code) < 3){
					$msg = '3桁以上の整数を入力してください';
					$this->setAction('index');
				}else{
					$post = $this->Post->getPostByCode($post_code);
					$subject          .= $post_code;
					$meta_keywords    .= ',' . $post_code;
					$meta_description  = '[ ' . $post_code . ' ]' . $meta_description;
				}
			}else{
				throw new Exception('パラメータエラー');
			}
			$title = ($subject === '')? '郵便番号検索': '郵便番号検索 [' . $subject . ']';
			$this->set(compact('title', 'meta_keywords', 'meta_description', 'subject', 'msg', 'city', 'post', 'act'));
		}catch(Exception $e){
//			var_dump($e);
			$this->setAction('index');
		}
	}
	public function city() {
		$this->_oldVersionRouting();
	}
	public function post() {
		$this->_oldVersionRouting();
	}
	private function _oldVersionRouting(){
		try{
			$pass = $this->params['pass'];
			if(count($pass) != 3){
				throw new Exception(__CLASS__ . ':' . __LINE__ . 'リクエストパラメータ数エラー[expect:3, but:' . count($pass) . ']');
			}
			$ken_code  = $pass[0];
			$city_code = $pass[1];
			$post_code = $pass[2];
			if(preg_match('/^\d+$/', $ken_code)){
				$this->redirect('http://hon.plala.jp/p/' . $this->name . '/search/city/' . $ken_code . '/');
			}elseif(preg_match('/^\d+$/', $city_code)){
				$this->redirect('http://hon.plala.jp/p/' . $this->name . '/search/post/' . $city_code . '/');
			}elseif(preg_match('/^\d+$/', $post_code)){
				$this->redirect('http://hon.plala.jp/p/' . $this->name . '/post/city/' . $post_code . '/');
			}else{
				$this->redirect('http://hon.plala.jp/p/' . $this->name . '/');
			}
		}catch(Exception $e){
//			echo var_dump($e);
			$this->setAction('index');
		}
	}
}
?>
