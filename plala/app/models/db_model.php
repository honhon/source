<?php
class DbModel{
	private static $_datasource = null;
	private static $_conn = null;
	
	private static function _getConnection(){
		if(self::$_conn === null){
			if(self::$_datasource === null){
				$dbconf = new DATABASE_CONFIG();
				self::$_datasource = $dbconf->default;
			}
			$ds = self::$_datasource;
			self::$_conn = new PDO($ds['driver'] . ':host=' . $ds['host'] . '; dbname=' . $ds['database']
								, $ds['login']
								, $ds['password']);
			self::$_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$_conn;
	}
	
	public static function disconnect(){
		self::$_conn = null;
	}

	public static function getAll($sql, $param=null){
		$stmt = self::execute($sql, $param);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getRow($sql, $param=null){
		$stmt = self::execute($sql, $param);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function execute($sql, $param=null){
		if(self::$_conn === null){
			self::_getConnection();
		}
		$stmt = self::$_conn->prepare($sql);
		if($param == null){
			$stmt->execute();
		}else{
			$stmt->execute($param);
		}
		return $stmt;
	}
}
?>