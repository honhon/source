<?php
class DbtoolController extends AppController {
	const TABLELIST_SQL_MYSQL = "SHOW TABLES";
	const TABLELIST_SQL_PGSQL = "SELECT TABLENAME AS TABLE_NAME FROM PG_TABLES WHERE NOT (TABLENAME LIKE 'pg_%' OR TABLENAME LIKE 'sql_%') ";
	var $uses = array();
	
	public function index() {
		$title            = 'DB検索ツール';
		$meta_keywords    = 'DB,検索,ツール';
		$meta_description = 'DB検索ツール';
		$this->set(compact('title', 'meta_keywords', 'meta_description'));
	}
	public function query(){
		$act = isset($_POST['act'])? $_POST['act']: '';
		$dbType = isset($_POST['dbType'])? $_POST['dbType']: '';
		$dbHost = isset($_POST['dbHost'])? $_POST['dbHost']: '';
		$dbName = isset($_POST['dbName'])? $_POST['dbName']: '';
		$dbPort = isset($_POST['dbPort'])? $_POST['dbPort']: '';
		$dbUser = isset($_POST['dbUser'])? $_POST['dbUser']: '';
		$dbPass = isset($_POST['dbPass'])? $_POST['dbPass']: '';
		$sql =    isset($_POST['sql'])?    $_POST['sql']:    '';
		$sql_lower = strtolower($sql);
		
		$res = array();
		try{
			$pdo = new PDO("$dbType:host=$dbHost; port=$dbPort; dbname=$dbName", $dbUser, $dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$res['status'] = 'ok';
			switch($act){
			case 'table':
				$tablelist_sql = ($dbType == 'pgsql')? self::TABLELIST_SQL_PGSQL: self::TABLELIST_SQL_MYSQL;
				$stmt = $pdo->prepare($tablelist_sql);
				$stmt->execute();
				$res['type'] = $act;
				$res['data'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
				$res['count'] = $stmt->rowCount();
				break;
			case 'sql':
				if(substr($sql_lower, 0, 6) == 'select' || substr($sql_lower, 0, 4) == 'show' || substr($sql_lower, 0, 7) == 'explain'){
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$res['type'] = $act;
					$aaa = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$header = array();
					$data = array();
					$blnFirst = true;
					foreach($aaa as $d){
						$tmp = array();
						foreach($d as $k => $v){
							if($blnFirst){
								$header[] = $k;
							}
							$tmp[] = $v;
						}
						$data[] = $tmp;
						$blnFirst = false;
					}
					$res['header'] = $header;
					$res['data'] = $data;
					$res['count'] = $stmt->rowCount();
					$res['message'] = $res['count'] == 0? 'データがありません': '';
					$res['sql'] = $sql;
				}elseif(substr($sql_lower, 0, 6) == 'insert' || substr($sql_lower, 0, 6) == 'update' || substr($sql_lower, 0, 6) == 'delete'){
					throw new Exception('許可されていないコマンドが入力されました');
					/*
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$res['type'] = $act;
					$res['header'] = '';
					$res['data'] = '';
					$res['count'] = $stmt->rowCount();
					$res['message'] = $res['count'] . '件更新しました';
					$res['sql'] = $sql;
					*/
				}elseif($sql ==''){
					throw new Exception('SQLが入力されていません');
				}else{
					throw new Exception('許可されていないコマンドが入力されました');
				}
				break;
			default:
				throw new Exception('許可されていないコマンドが入力されました');
			}
		}catch(Exception $e){
			$res = array('status' => 'ng'
						, 'error' => 'エラーが発生しました: ' . $e->getMessage());
		}
		echo self::toJson($res);
		exit;
	}
	
	private static function toJson($data){
		return '{' . self::getJsonContents($data) . '}';
	}
	private static function getJsonContents($data){
		$json = array();
		foreach($data as $string => $value){
			$key = is_numeric($string)? '': $string;
			$str  = ($key == '')? '': '"' . self::format($key) . '":';
			$str .= (is_array($value))? '[' . self::getJsonContents($value) . ']': '"' . self::format($value) . '"';
			$json[] = $str;
		}
		return implode(",", $json);
	}
	private static function format($str){
		return str_replace(array("\r\n","\r","\n"), '<br />', htmlspecialchars($str, ENT_QUOTES));
	}
}
?>
