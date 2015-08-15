<?php
App::import('Model', 'DbModel');
class Post {
	public function getKenAll(){
		$sql = 'select code, name from tbl_ken order by code';
		return DbModel::getAll($sql);
	}
	
	public function getCity($ken_code){
		$sql = 'select code, name, kana from tbl_city where ken_code = :ken_code order by code';
		$param = array(':ken_code' => $ken_code);
		return DbModel::getAll($sql, $param);
	}
	
	public function getPostByCityCode($city_code){
		$sql = 'select p.code as post_code, c.code as city_code, k.code as ken_code'
			. ' , p.kana as post_kana, c.kana as city_kana, k.kana as ken_kana'
			. ' , p.name as post_name, c.name as city_name, k.name as ken_name'
			. ' from tbl_post p, tbl_city c, tbl_ken k'
			. ' where p.city_code = c.code and c.ken_code = k.code and c.code = :city_code'
			. '  ';
		$param = array(':city_code' => $city_code);
		return DbModel::getAll($sql, $param);
	}
	
	public function getPostByCode($post_code){
		$sql = 'select p.code as post_code, c.code as city_code, k.code as ken_code'
			. ' , p.kana as post_kana, c.kana as city_kana, k.kana as ken_kana'
			. ' , p.name as post_name, c.name as city_name, k.name as ken_name'
			. ' from tbl_post p, tbl_city c, tbl_ken k'
			. ' where p.city_code = c.code and c.ken_code = k.code and p.code like :post_code'
			. '  ';
		$param = array(':post_code' => $post_code . '%');
		return DbModel::getAll($sql, $param);
	}
	
	public function getKenName($ken_code){
		$sql = 'select name from tbl_ken where code = :ken_code';
		$param = array(':ken_code' => $ken_code);
		$ret = DbModel::getRow($sql, $param);
		return isset($ret['name'])? $ret['name']: '';
	}
	
	public function getCityName($city_code){
		$sql = 'select name from tbl_city where code = :city_code';
		$param = array(':city_code' => $city_code);
		$ret = DbModel::getRow($sql, $param);
		return isset($ret['name'])? $ret['name']: '';
	}

        public function upload($aryFile){
                $tmp_ken_code = '';
                $tmp_city_code = '';
                $cnt = 0;
                try{
                        $sql = 'truncate table tbl_ken';
                        DbModel::execute($sql);

                        $sql = 'truncate table tbl_city';
                        DbModel::execute($sql);
                        
                        $sql = 'truncate table tbl_post';
                        DbModel::execute($sql);

                        $sqlK = 'insert into tbl_ken(code, kana, name) values(?,?,?)';
                        $sqlC = 'insert into tbl_city(code, ken_code, kana, name) values(?,?,?,?)';
                        $sqlP = 'insert into tbl_city(code, city_code, seq_no, kana, name) values(?,?,?,?,?)';
                        //0:city_code, 1:?, 2:post_code, 3:ken_kana, 4:city_kana, 5:post_kana, 6:ken_name, 7:city_name, 8:post_name
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
                                        if(count($aryRow) < 9){ continue; }

                                        $ken_code  = substr($aryRow[0], 0, 2);
                                        $city_code = $aryRow[0];
                                        $post_code = $aryRow[2];
                                        if($tmp_ken_code !== $ken_code){
                                                $tmp_ken_code = $ken_code;
                                                $param = array($ken_code, $aryRow[3], $aryRow[6]);
                                                DbModel::execute($sqlK, $param);
                                        }
                                        if($tmp_city_code !== $city_code){
                                                $tmp_city_code = $city_code;
                                                $param = array($city_code, $aryRow[4], $aryRow[7]);
                                                DbModel::execute($sqlC, $param);
                                        }
                                        $param = array($post_code, $city_code, $cnt, $aryRow[5], $aryRow[8]);
                                        DbModel::execute($sqlS, $param);
                                        $cnt++;
                                }
                                fclose($fp);
                        }
                }catch(Exception $e){
                        return $e;
                }
                return $cnt;
        }

}
?>
