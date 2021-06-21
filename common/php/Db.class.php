<?php
/**
 *  DB - A simple database class 
 *
 * @author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 * @git 		https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
 * @version      0.2ab
 *
 */
require("Log.class.php");
class DB
{
	# @object, The PDO object
	private $pdo;
	
	# @object, PDO statement object
	private $sQuery;
	
	# @array,  The database settings
	private $settings;
	
	# @bool ,  Connected to the database
	private $bConnected = false;
	
	# @object, Object for logging exceptions	
	private $log;
	
	# @array, The parameters of the SQL query
	private $parameters;
	
	/**
	 *   Default Constructor 
	 *
	 *	1. Instantiate Log class.
	 *	2. Connect to database.
	 *	3. Creates the parameter array.
	 */
	public function __construct()
	{
		$this->log = new Log();
		$this->Connect();
		$this->parameters = array();
	}
	
	/**
	 *	This method makes connection to the database.
	 *	
	 *	1. Reads the database settings from a ini file. 
	 *	2. Puts  the ini content into the settings array.
	 *	3. Tries to connect to the database.
	 *	4. If connection failed, exception is displayed and a log file gets created.
	 */
	private function Connect()
	{
		$this->settings = parse_ini_file("settings.ini.php");
//        $dsn            = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
		$dsn            = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . '';
		try {
			# Read settings from INI file, set UTF8
//            $this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"], array(
			$this->pdo = new PDO($dsn, DB_USER, DB_PASS, array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			));
			
			# We can now log any exceptions on Fatal error. 
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			# Disable emulation of prepared statements, use REAL prepared statements instead.
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
			# Connection succeeded, set the boolean to true.
			$this->bConnected = true;
		}
		catch (PDOException $e) {
			# Write into log
			echo $this->ExceptionLog($e->getMessage());
			die();
		}
	}
	/*
	 *   You can use this little method if you want to close the PDO connection
	 *
	 */
	public function CloseConnection()
	{
		# Set the PDO object to null to close the connection
		# http://www.php.net/manual/en/pdo.connections.php
		$this->pdo = null;
	}
	
	/**
	 *	Every method which needs to execute a SQL query uses this method.
	 *	
	 *	1. If not connected, connect to the database.
	 *	2. Prepare Query.
	 *	3. Parameterize Query.
	 *	4. Execute Query.	
	 *	5. On exception : Write Exception into the log + SQL query.
	 *	6. Reset the Parameters.
	 */
	private function Init($query, $parameters = "", $bindkind = "")
	{
		# Connect to database
		if (!$this->bConnected) {
			$this->Connect();
		}
		try {
			# Prepare query
			$this->sQuery = $this->pdo->prepare($query);
			
			if (!empty($bindkind)) {
				$arrayStart = 1;
				for ($i = 0; $i < count($parameters); $i++) {
						$type = PDO::PARAM_STR;
						switch ($value[1]) {
							case is_int($value[1]):
								$type = PDO::PARAM_INT;
								break;
							case is_bool($value[1]):
								$type = PDO::PARAM_BOOL;
								break;
							case is_null($value[1]):
								$type = PDO::PARAM_NULL;
								break;
						}
					$this->sQuery->bindValue($arrayStart, $parameters[$i], $type);
					$arrayStart++;
				}
			} else {
				# Add parameters to the parameter array	
				$this->bindMore($parameters);
				
				# Bind parameters
				if (!empty($this->parameters)) {
					foreach ($this->parameters as $param => $value) {
						
						$type = PDO::PARAM_STR;
						switch ($value[1]) {
							case is_int($value[1]):
								$type = PDO::PARAM_INT;
								break;
							case is_bool($value[1]):
								$type = PDO::PARAM_BOOL;
								break;
							case is_null($value[1]):
								$type = PDO::PARAM_NULL;
								break;
						}
						// Add type when binding the values to the column
						$this->sQuery->bindValue($value[0], $value[1], $type);
					}
				}
			}
			
			# Execute SQL 
			$this->sQuery->execute();
		}
		catch (PDOException $e) {
			# Write into log and display Exception
			echo $this->ExceptionLog($e->getMessage(), $this->sql_debug($query, $parameters));
			die();
		}
		
		# Reset the parameters
		$this->parameters = array();
	}
	
	/**
	 *	@void 
	 *
	 *	Add the parameter to the parameter array
	 *	@param string $para  
	 *	@param string $value 
	 */
	public function bind($para, $value)
	{
		$this->parameters[sizeof($this->parameters)] = [":" . $para , $value];
	}
	/**
	 *	@void
	 *	
	 *	Add more parameters to the parameter array
	 *	@param array $parray
	 */
	public function bindMore($parray)
	{
		if (empty($this->parameters) && is_array($parray)) {
			$columns = array_keys($parray);
			foreach ($columns as $i => &$column) {
				$this->bind($column, $parray[$column]);
			}
		}
	}
	/**
	 *  If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
	 *	If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
	 *
	 *   	@param  string $query
	 *	@param  array  $params
	 *	@param  int    $fetchmode
	 *	@return mixed
	 */
	public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$query = trim(str_replace("\r", " ", $query));
		
		$this->Init($query, $params);
		
		$rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
		
		# Which SQL statement is used 
		$statement = strtolower($rawStatement[0]);
		
		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this->sQuery->rowCount();
		} else {
			return NULL;
		}
	}
	
	/**
	 *  Returns the last inserted id.
	 *  @return string
	 */
	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	
	/**
	 * Starts the transaction
	 * @return boolean, true on success or false on failure
	 */
	public function beginTransaction()
	{
		return $this->pdo->beginTransaction();
	}
	
	/**
	 *  Execute Transaction
	 *  @return boolean, true on success or false on failure
	 */
	public function executeTransaction()
	{
		return $this->pdo->commit();
	}
	
	/**
	 *  Rollback of Transaction
	 *  @return boolean, true on success or false on failure
	 */
	public function rollBack()
	{
		return $this->pdo->rollBack();
	}
	
	/**
	 *	Returns an array which represents a column from the result set 
	 *
	 *	@param  string $query
	 *	@param  array  $params
	 *	@return array
	 */
	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);
		
		$column = null;
		
		foreach ($Columns as $cells) {
			$column[] = $cells[0];
		}
		
		return $column;
		
	}
	/**
	 *	Returns an array which represents a row from the result set 
	 *
	 *	@param  string $query
	 *	@param  array  $params
	 *   	@param  int    $fetchmode
	 *	@return array
	 */
	public function row($query, $params = null, $bindkind="", $fetchmode = PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params, $bindkind);
		$result = $this->sQuery->fetch($fetchmode);
		$this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
		return $result;
	}
	/**
	 *	Returns the value of one single field/column
	 *
	 *	@param  string $query
	 *	@param  array  $params
	 *	@return string
	 */
	public function single($query, $params = null)
	{
		$this->Init($query, $params);
		$result = $this->sQuery->fetchColumn();
		$this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
		return $result;
	}
	/**	
	 * Writes the log and returns the exception
	 *
	 * @param  string $message
	 * @param  string $sql
	 * @return string
	 */
	private function ExceptionLog($message, $sql = "")
	{
		$exception = '오류가 발생했습니다. 관리자에게 문의해 주세요.';

		if ("112.220.102.26" == $_SERVER[ 'REMOTE_ADDR'] || "1.221.13.67" == $_SERVER[ 'REMOTE_ADDR'] ) {
			$exception .= "<br />".$message;
			$exception .= "<br />".$sql;
		}

		if (!empty($sql)) {
			# Add the Raw SQL to the Log
			$message .= "\r\nRaw SQL : " . $sql;

		}
		# Write into log
		$this->log->write($message);
		
		return $exception;
	}

	function sql_debug($sql_string, array $params = null) {
		if (!empty($params)) {
			$indexed = $params == array_values($params);
			$indexed = is_array($params[0]) ? 3 : $indexed;

			foreach($params as $k=>$v) {
				if (is_object($v)) {
					if ($v instanceof \DateTime) $v = $v->format('Y-m-d H:i:s');
					else continue;
				} elseif (is_string($v)) {
					$v="'$v'";
				} elseif ($v === null) {
					$v='NULL';
				} elseif (is_array($v) && $indexed!=3) {
					$v = implode(',', $v);
				}

				if (is_array($v)) {
					foreach($v as $kk=>$vv) {
						if ($kk[0] != ':') $kk = ':'.$kk;
						$sql_string = str_replace($kk,$vv,$sql_string);
					}
				} else if ($indexed) {
					$sql_string = preg_replace('/\?/', $v, $sql_string, 1);
				} else {
					if ($k[0] != ':') $k = ':'.$k;
					$sql_string = str_replace($k,$v,$sql_string);
				}
			}
		}

		return $sql_string;
	}
}
?>