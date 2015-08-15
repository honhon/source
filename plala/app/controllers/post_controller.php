<?php
class PostController extends AppController {
	var $uses = array('Post');
	var $msg = '';
	
	public function beforeFilter(){
		$title = '郵便番号検索';
		$meta_keywords = '郵便番号,検索,本田郵便局';
		$meta_description = '本田郵便局では郵便番号が簡単に調べられます。市町村、または、郵便コードからお探しの情報が検索できます。モバイル端末にも対応しています。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	
	public function index() {
		$ken = $this->Post->getKenAll();
		$this->set(compact('ken'));
	}
	
	public function search(){
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$status = 0;
		$city = array();
		$post = array();
		
		$act         = $this->request->getParam('act', '');
		$ken_code    = $this->request->getParam('kenCode', '');
		$city_code   = $this->request->getParam('cityCode', '');
		$post_code   = $this->request->getParam('postCode', '');
		try{
			if($act == 'city'      && preg_match('/^\d+$/', $ken_code) == 1){
				$city = $this->Post->getCity($ken_code);
			}elseif($act == 'post' && preg_match('/^\d+$/', $city_code) == 1){
				$post = $this->Post->getPostByCityCode($city_code);
			}elseif($act == 'post' && preg_match('/^\d+$/', $post_code) == 1){
				$post = $this->Post->getPostByCode($post_code);
			}else{
				throw new Exception('パラメータエラー');
			}
		}catch(Exception $e){
			$this->log($e->__toString());
			$status = 404;
		}
		$postData = array('status' => $status
						, 'city' =>   $city
						, 'post' =>   $post);
		$this->set(compact('postData'));
		$this->render('jsondata');
	}
}
?>
