<?php
class AppController extends Controller {
	public function __construct(){
		parent::__construct();
		$this->components[] = 'request';
		$this->helpers[] = 'javascript';
		
		$title = '金融機関支店番号検索(銀行,信用金庫,農協,漁連)';
		$this->set(compact('title'));
	}
}
?>
