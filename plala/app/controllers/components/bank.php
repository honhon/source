<?php
class BankComponent{
	private $aryKanaHead = array('ｱ','ｶ','ｻ','ﾀ','ﾅ','ﾊ','ﾏ','ﾔ','ﾗ','ﾜ'
				,'ｲ','ｷ','ｼ','ﾁ','ﾆ','ﾋ','ﾐ','-','ﾘ','-'
				,'ｳ','ｸ','ｽ','ﾂ','ﾇ','ﾌ','ﾑ','ﾕ','ﾙ','-'
				,'ｴ','ｹ','ｾ','ﾃ','ﾈ','ﾍ','ﾒ','-','ﾚ','-'
				,'ｵ','ｺ','ｿ','ﾄ','ﾉ','ﾎ','ﾓ','ﾖ','ﾛ','-');
	private $aryKanaHeadZen = array( 'ア','カ','サ','タ','ナ','ハ','マ','ヤ','ラ','ワ'
					,'イ','キ','シ','チ','ニ','ヒ','ミ','－','リ','－'
					,'ウ','ク','ス','ツ','ヌ','フ','ム','ユ','ル','－'
					,'エ','ケ','セ','テ','ネ','ヘ','メ','－','レ','－'
					,'オ','コ','ソ','ト','ノ','ホ','モ','ヨ','ロ','－');
	private $aryMainBank = array('0001' => 'みずほ銀行'
				,'0005' => '三菱東京UFJ銀行'
				,'0009' => '三井住友銀行銀行'
				,'0010' => 'りそな銀行'
				,'0017' => '埼玉りそな銀行'
				,'0033' => 'ジャパンネット銀行'
				,'0034' => 'セブン銀行'
				,'0035' => 'ソニー銀行'
				,'0036' => '楽天銀行'
				,'0037' => '日本振興銀行'
				,'0038' => '住信SBIネット銀行'
				,'0039' => 'じぶん銀行'
				,'0040' => 'イオン銀行');
	private $aryMainBankUrl = array( '0001' => 'http://www.mizuhobank.co.jp/'
					,'0005' => 'http://www.bk.mufg.jp/'
					,'0009' => 'http://www.smbc.co.jp/'
					,'0010' => 'http://www.resona-gr.co.jp/resonabank/'
					,'0017' => 'http://www.resona-gr.co.jp/saitamaresona/'
			   		,'0033' => 'http://www.japannetbank.co.jp/'
					,'0034' => 'http://www.sevenbank.co.jp/'
					,'0035' => 'http://moneykit.net/'
					,'0036' => 'http://www.rakuten-bank.co.jp/'
					,'0037' => 'http://www.shinkobank.co.jp/'
					,'0038' => 'http://www.netbk.co.jp/'
					,'0039' => 'http://www.jibunbank.co.jp/'
					,'0040' => 'http://www.aeonbank.co.jp/');

	public function startup(&$controller) {
		$controller->set(
				array('aryKanaHead'    => $this->aryKanaHead
					, 'aryKanaHeadZen' => $this->aryKanaHeadZen
					, 'aryMainBank'    => $this->aryMainBank
					, 'aryMainBankUrl' => $this->aryMainBankUrl));
	}

	public function getKanaHead($blnZen=false){
		return $blnZen? $this->aryKanaHeadZen: $this->aryKanaHead;
	}

	public function getMainBank(){
		return $this->aryMainBank;
	}

	public function getMainBankUrl(){
		return $this->aryMainBankUrl;
	}
}
?>
