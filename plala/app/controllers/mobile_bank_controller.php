<?php
class MobileBankController extends AppController {
	var $components = array('bank', 'MobileFilter');
	var $uses = array('Bank');
	var $layout = 'mobile';
	var $header_title     = '金融機関支店番号 支店コード検索[銀行,信用金庫,農協,漁連][モバイル版]';
	var $meta_keywords    = '支店番号,支店コード,銀行コード,金融機関コード,検索,銀行,信用金庫,農協,漁連,モバイル端末';
	var $meta_description = '金融機関の支店番号(支店コード)が簡単に調べられます。銀行,信用金庫,農協,漁連に対応しています。モバイル端末にも対応しています。';
	
	public function beforeFilter(){
		$title            = $this->header_title;
		$meta_keywords    = $this->meta_keywords;
		$meta_description = $this->meta_description;
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	
	public function index() {}
	
	public function search(){
		try{
			$pass = $this->params['pass'];
			switch(count($pass)){
			case 1:
				if(preg_match('/^\d{4}$/', $pass[0])){
					$bankInfo =& $this->Bank->getBankByCode($pass[0]);
					$this->set('bankInfo', $bankInfo);
					$shitenInfo =& $this->Bank->getBankDetails($pass[0]);
					$this->set('shitenInfo', $shitenInfo);
					if(count($bankInfo) > 0){
						$this->header_title = $bankInfo[0]['bank_name'] . '[' . $bankInfo[0]['bank_code'] . ']: ' . $this->header_title;
						$this->meta_keywords = $bankInfo[0]['bank_name'] . ',' . $bankInfo[0]['bank_code'] . ',' . $this->meta_keywords;
						$this->meta_description = $bankInfo[0]['bank_name'] . '[' . $bankInfo[0]['bank_code'] . ']: ' . $this->meta_description;
						$this->set(array('title' => $this->header_title, 'meta_keywords' => $this->meta_keywords, 'meta_description' => $this->meta_description));
					}
					$this->render('searchShiten');
				}else{
					$bankInfo = $this->Bank->getBankByKana($pass[0]);
					if(count($bankInfo) > 0){
						$this->header_title = $this->header_title . ' [' . $pass[0] . 'で検索]';
						$this->meta_keywords = $this->meta_keywords . ',' . $pass[0];
						$this->meta_description = '[' . $pass[0] . 'で検索]: ' . $this->meta_description;
					}
					$this->set(array('title' => $this->header_title, 'bankInfo' => $bankInfo, 'meta_keywords' => $this->meta_keywords, 'meta_description' => $this->meta_description));
					$this->render('searchBank');
				}
				break;
			case 2:
				$bankInfo =& $this->Bank->getBankByCode($pass[0]);
				$this->set('bankInfo', $bankInfo);
				$shitenInfo =& $this->Bank->getBankDetails($pass[0], $pass[1] );
				$this->set('shitenInfo', $shitenInfo);
				if(count($bankInfo) > 0){
					$this->header_title = $bankInfo[0]['bank_name'] . '[' . $bankInfo[0]['bank_code'] . ']: ' . $this->header_title . ' [' . $pass[1] . 'で検索]';
					$this->meta_keywords = $bankInfo[0]['bank_name'] . ',' . $bankInfo[0]['bank_code'] . ',' . $this->meta_keywords . ',' . $pass[1];
					$this->meta_description = $bankInfo[0]['bank_name'] . '[' . $bankInfo[0]['bank_code'] . ']: ' . $this->meta_description . ' [' . $pass[1] . 'で検索]';
					$this->set(array('title' => $this->header_title, 'meta_keywords' => $this->meta_keywords, 'meta_description' => $this->meta_description, 'kana' => $pass[1]));
				}
				$this->render('searchShiten');
				break;
			default:
				throw new Exception(__CLASS__ . ':' . __LINE__ . 'リクエストパラメータ数エラー');
				break;
			}
		}catch(Exception $e){
			$this->setAction('index');
		}
	}
	
	public function bank() {
		$this->_oldVersionRouting();
	}
	public function shiten() {
		$this->_oldVersionRouting();
	}
	private function _oldVersionRouting(){
		try{
			$pass = $this->params['pass'];
			if(count($pass) != 4){
				throw new Exception(__CLASS__ . ':' . __LINE__ . 'リクエストパラメータ数エラー[expect:4, but:' . count($pass) . ']');
			}
			$bank_code        = $pass[0];
			$bank_kana_code   = $pass[2];
			$shiten_kana_code = $pass[3];
			$aryKanaHead = $this->bank->getKanaHead();
			if(preg_match('/^\d+$/', $bank_code)){
				if(preg_match('/^\d+$/', $shiten_kana_code)){
					$this->redirect('http://hon.plala.jp/p/' . $this->name . '/search/' . $bank_code . '/' . urlencode($aryKanaHead[$shiten_kana_code]) . '/');
				}else{
					$this->redirect('http://hon.plala.jp/p/' . $this->name . '/search/' . $bank_code . '/');
				}
			}elseif(preg_match('/^\d+$/', $bank_kana_code)){
					$this->redirect('http://hon.plala.jp/p/' . $this->name . '/search/' . urlencode($aryKanaHead[$bank_kana_code]) . '/');
			}else{
				throw new Exception(__CLASS__ . ':' . __LINE__ . 'リクエストパラメータエラー');
			}
		}catch(Exception $e){
			var_dump($e);
			$this->setAction('index');
		}
	}
}
?>
