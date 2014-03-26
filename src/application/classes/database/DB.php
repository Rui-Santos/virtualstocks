<?php

class DB
{
	/**
	 * Stores the DB-instance
	 * @var DB $dbInstance
	 */
	protected static $dbInstance;
	
	/**
	 * Stores the DB connection
	 * @var mySQL Connection $dbConnection
	 */
	protected $dbConnection;
	
	/**
	 * returns the DB-instance
	 * @return DB
	 */
	public static function get() {
		if (!isset(self::$dbInstance)) {
			self::$dbInstance = self::createConnection();
			self::$dbInstance->connect();
		}
		return self::$dbInstance;
	}
	
	private static function createConnection() {
		return new self();
	}
	
	public function connect() {
		if (!$this->dbConnection) {
			$this->dbConnection = mysql_connect(Config::DATABASE_HOST, Config::DATABASE_USER, Config::DATABASE_PASS);
			mysql_select_db(Config::DATABASE_NAME, $this->dbConnection);
		}
	}
	
	public function disconnect() {
		return $this->dbConnection ? mysql_close($this->dbConnection) : false;
	}
	
	public function query($dbQuery) {
		$args = func_get_args();
		unset($args[0]);
		return (count($args) == 1 && is_array($args[1])) ? $this->sendQuery($dbQuery, $args[1]) : $this->sendQuery($dbQuery, $args);
	}
	
	public function escape($dbString) {
		return mysql_real_escape_string($dbString, $this->dbConnection);
	}
	
	private function sendQuery($dbQuery, $args) {
		$escapedArray = array();
		foreach ($args as $value) {
			$escapedArray[] = $this->escape($value);
		}
		
		$queryResource = @mysql_query(vsprintf($dbQuery, $escapedArray), $this->dbConnection);
		return $this->toResult($queryResource, $dbQuery);
	}

	protected function toResult($queryResource, $dbQuery) {
		return new DBResult($queryResource);
	}

	private function __construct() {}
	private function __clone() {}
}
