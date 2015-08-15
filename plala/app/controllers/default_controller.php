<?php
class DefaultController extends AppController {
	var $uses = array();

	public function beforeFilter(){
		$title = '金融機関支店番号検索(銀行,信用金庫,農協,漁連)';
		$meta_keywords = '支店番号,検索,銀行,支店コード,信用金庫,農協,漁連';
		$meta_description = '金融機関の支店番号が簡単に調べられます。銀行,信用金庫,農協,漁連に対応しています。';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	
	public function index() {}
}
?>