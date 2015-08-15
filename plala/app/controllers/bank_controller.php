<?php
class BankController extends AppController {
	var $components = array('bank');
	var $uses = array('Bank');

	public function beforeFilter(){
		$title            = '金融機関支店番号(支店コード)検索[銀行,信用金庫,農協,漁連]';
		$meta_keywords    = '支店番号,支店コード,銀行コード,金融機関コード,検索,銀行,信用金庫,農協,漁連,モバイル端末';
		$meta_description = '金融機関の支店番号(支店コード)が簡単に調べられます。銀行,信用金庫,農協,漁連に対応しています。モバイル端末にも対応しています。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}

	public function index() {}
	
	public function search(){
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$bank_info = array();
		$shiten_info = array();
		$status = 0;
		try{
			$act         = $this->request->getParam('act', '');
			$bank_code   = $this->request->getParam('bankCode', '');
			$bank_kana   = $this->request->getParam('bankKana', '');
			$shiten_code = $this->request->getParam('shitenCode', '');
			$shiten_kana = $this->request->getParam('shitenKana', '');
			if($act == 'bank' && $bank_kana != ''){
				$bank_info = $this->Bank->getBankByKana($bank_kana);
			}elseif($act == 'shiten'){
				$bank_info = $this->Bank->getBankByCode($bank_code);
				$shiten_info = $this->Bank->getBankDetails($bank_code, $shiten_kana, $shiten_code);
			}
		}catch(Exception $e){
			$this->log($e->__toString());
			$status = 404;
		}
		$bankData = array('status' =>     $status
						, 'bankInfo' =>   $bank_info
						, 'shitenInfo' => $shiten_info);
		$this->set(compact('bankData'));
		$this->render('jsondata');
	}

	public function map(){
		$bank_code   = $this->request->getParam('bankCode', '');
		$shiten_code = $this->request->getParam('shitenCode', '');
		$shiten_seq  = $this->request->getParam('shitenSeq', '');
		if($bank_code.$shiten_code.$shiten_seq != ''){
			$address = $this->Bank->getFullAddress($bank_code, $shiten_code, $shiten_seq);
			$this->redirect('http://local.google.co.jp/local?q=' . urlencode($address));
		}
	}
	
	public function upload() {
		if(!$this->_uploadAuthorize()){
			$this->set('errMsg', '参照権限がありません');
			$this->render('error');
			return true;
		}
		$cnt = 0;
		if($this->request->isPost()){
			$blnFileSelect = true;
			if(!isset($_FILES['bank1']['tmp_name']) || $_FILES['bank1']['tmp_name'] == ''){ $blnFileSelect = false; }
//			if(!isset($_FILES['bank2']['tmp_name']) || $_FILES['bank2']['tmp_name'] == ''){ $blnFileSelect = false; }
//			if(!isset($_FILES['bank3']['tmp_name']) || $_FILES['bank3']['tmp_name'] == ''){ $blnFileSelect = false; }
//			if(!isset($_FILES['bank4']['tmp_name']) || $_FILES['bank4']['tmp_name'] == ''){ $blnFileSelect = false; }
			if(!$blnFileSelect){
				$this->set('errMsg', 'ファイルが選択されていません');
				$this->render('upload');
				return true;
			}
                        $start = time();
			$aryFile = array();
			$aryFile[] = $_FILES['bank1'];
//			$aryFile[] = $_FILES['bank2'];
//			$aryFile[] = $_FILES['bank3'];
//			$aryFile[] = $_FILES['bank4'];
			try{
				$cnt = $this->Bank->upload($aryFile);
			}catch(Exception $e){
				$this->set('errMsg', 'アップロード失敗しました');
				$this->render('upload');
				return true;
			}
                        $end = time();
                        $time = (int)(($end - $start) / 60) . '分' . (($end - $start) % 60) . '秒';
			$this->set('msg', 'アップロード完了しました -- ' . $cnt . '件 -- (' . $time . ')');
		}
		$this->render('upload');
	}

	private function _uploadAuthorize(){
		if(preg_match('/^' . MANAGER_IP . '$/', $_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
			return true;
		}
		return false;
	}
}
?>
