<?php

class DBResult {
	/**
	 * Stores the mySQL resource
	 * @var mySQL Resource $dbResult
	 */
	private $dbResult;
	
	public function __construct($dbResult) {
		$this->dbResult = &$dbResult;
	}
	
	public function fetch_assoc() {
		return mysql_fetch_assoc($this->dbResult);
	}
	
	public function fetch_row() {
		return mysql_fetch_array($this->dbResult);
	}

	public function fetch_value() {
		$value = $this->fetch_row();
		return ($value === false) ? null : $value[0];
	}
	
	public function fetch_assocs() {
		$assocs = array();
		while (($assoc = $this->fetch_assoc())) {
			$assocs[] = $assoc;
		}
		return $assocs;
	}
	
	public function fetch_values($key_index, $value_index) {
		$rows = array();
		while (($row = $this->fetch_row())) {
			if ($key_index != -1) {
				$key_value = $row[$key_index];
				$rows[$key_value] = $row[$value_index];
			} else {
				$rows[] = $row[$value_index];
			}
		}
		return $rows;
	}
	
	public function num_rows() {
		return mysql_num_rows($this->dbResult);
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->dbResult);
	}
}
