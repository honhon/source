<?php
App::import('Model', 'DbModel');
class Bank{
	public function getBankByCode($bank_code){
		$sql = 'select * from tbl_bank where bank_code = :bank_code order by bank_code';
		$param = array(':bank_code' => $bank_code);
		$list = DbModel::getAll($sql, $param);
		if(count($list) > 0){
			foreach($list as $k => $row){
				$list[$k]['bank_name'] .= ($row['bank_code'] < 1000 || $row['bank_code'] == 9900)? '銀行': '';
			}
		}
		return $list;
	}
	public function getBankByKana($bank_kana){
		$sql = 'select * from tbl_bank where bank_kana like :bank_kana order by bank_code';
		$param = array(':bank_kana' => $bank_kana . '%');
		$list = DbModel::getAll($sql, $param);
		if(count($list) > 0){
			foreach($list as $k => $row){
				$list[$k]['bank_name'] .= ($row['bank_code'] < 1000 || $row['bank_code'] == 9900)? '銀行': '';
			}
		}
		return $list;
	}
	public function getBankDetails($bank_code, $shiten_kana = '', $shiten_code = ''){
		$param = array();
		$sql  = 'select * from tbl_bank_details where bank_code = :bank_code ';		$param[':bank_code'] = $bank_code;
		if($shiten_kana !== ''){ $sql .= ' and shiten_kana like :shiten_kana ';		$param[':shiten_kana'] =  $shiten_kana . '%'; }
		if($shiten_code !== ''){ $sql .= ' and shiten_code = :shiten_code ';		$param[':shiten_code'] =  $shiten_code; }
		$sql .= ' order by shiten_code, seq_no';
		return DbModel::getAll($sql, $param);
	}
	public function getAddress($bank_code, $shiten_code, $seq_no){
		$sql = 'select address from tbl_bank_details '
			. ' where bank_code = :bank_code and shiten_code = :shiten_code and seq_no = :seq_no ';
		$param = array(':bank_code' => $bank_code, ':shiten_code' => $shiten_code, ':seq_no' => $seq_no);
		$row = DbModel::getRow($sql, $param);
		if(!isset($row['address'])){return '';}
		return $row['address'];
	}
	public function getFullAddress($bank_code, $shiten_code, $seq_no){
		$sql = 'select k.name, b.address from tbl_bank_details b '
			. ' left join tbl_post p on b.zip_code  = p.code '
			. ' left join tbl_city c on p.city_code = c.code '
			. ' left join tbl_ken  k on c.ken_code  = k.code '
			. ' where b.bank_code = :bank_code and b.shiten_code = :shiten_code and b.seq_no = :seq_no ';
		$param = array(':bank_code' => $bank_code, ':shiten_code' => $shiten_code, ':seq_no' => $seq_no);
		$row = DbModel::getRow($sql, $param);
		if($row == false){
			return '';
		}elseif($row['address'] == null || $row['address'] ==''){
			return '';
		}elseif($row['name'] == null || $row['name'] ==''){
			return $row['address'];
		}elseif(mb_strpos($row['address'], $row['name']) === 0){
			return $row['address'];
		}else{
			return $row['name'] . $row['address'];
		}
	}
	public function upload($aryFile){
		$tmpBankCode = '';
		$cntB = 0;
		$cntS = 0;
		try{
			$sql = 'truncate table tbl_bank';
			DbModel::execute($sql);
			$sql = 'truncate table tbl_bank_details';
			DbModel::execute($sql);
			$sqlB = 'insert into tbl_bank(bank_code, bank_kana, bank_name) values(?,?,?)';
			$sqlS = 'insert into tbl_bank_details '
				. ' (bank_code, shiten_code, seq_no, shiten_kana, shiten_name, zip_code, address, tel, oya_flg) '
				. ' values(?,?,?,?,?,"","","","")';
			set_time_limit(300);
			foreach($aryFile as $f){
				if(!($fp = fopen($f['tmp_name'], 'r'))){
					throw new Exception('ファイル読み込みエラー '. $f['name']);
				}
				while(!feof($fp)){
					$row = trim(fgets($fp));
					$row = mb_convert_encoding($row, 'utf-8', 'sjis');
					$row = str_replace('"', '', $row);
					$aryRow = split(',', $row);
					if(count($aryRow) < 5){ continue; }
                                        
                                        $bank_code = trim($aryRow[0]);
                                        $shiten_code = trim($aryRow[1]);
                                        $kana = trim($aryRow[2]);
                                        $name = trim($aryRow[3]);
                                        $type = trim($aryRow[4]);
					if($type === "1"){
						$param = array($bank_code, $kana, $name);
						DbModel::execute($sqlB, $param);
						$cntB++;
					}else{
						$param = array($bank_code, $shiten_code, $cntS++, $kana, $name);
					        DbModel::execute($sqlS, $param);
				        }
				}
				fclose($fp);
			}
		}catch(Exception $e){
			throw $e;
		}
                echo $cntB . ":" . $cntS;
		return $cntS;
	}

	public function upload2($aryFile){
		$tmpBankCode = '';
		$cntB = 0;
		$cntS = 0;
		try{
			$sql = 'truncate table tbl_bank';
			DbModel::execute($sql);
			
//			$sql = 'truncate table tbl_bank_details';
//			DbModel::execute($sql);
			
			$sqlB = 'insert into tbl_bank(bank_code, bank_kana, bank_name) values(?,?,?)';
			$sqlS = 'insert into tbl_bank_details '
				. ' (bank_code, shiten_code, seq_no, shiten_kana, shiten_name, zip_code, address, tel, oya_flg) '
				. ' values(?,?,?,?,?,?,?,?,?)';
			//0:bankcode, 1:shitencode, 2:bankkana, 3:bankname, 4:shitenkana, 5:shitenname,
			//6:zipcode, 7:address, 8:tel, 9:tegata, 10:oyaflg
			set_time_limit(300);
			foreach($aryFile as $f){
				if(!($fp = fopen($f['tmp_name'], 'r'))){
					throw new Exception('ファイル読み込みエラー '. $f['name']);
				}
				while(!feof($fp)){
					$row = trim(fgets($fp));
					$row = mb_convert_encoding($row, 'utf-8', 'sjis');
					$row = str_replace('"', '', $row);
					$aryRow = split(',', $row);
					if(count($aryRow) < 4){ continue; }
					
					$param = array($aryRow[0], $aryRow[2], $aryRow[3]);
					DbModel::execute($sqlB, $param);
					$cntB++;
				}
				fclose($fp);
			}
		}catch(Exception $e){
			return $e;
		}
		return $cntB;
	}
}
?>
