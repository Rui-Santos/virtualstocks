<?php

class Depot
{
	/**
	 * Stores the Depot Number (ID)
	 * @var Integer $depotNumber
	 */
	protected $depotNumber;
	
	public function __construct($depotNumber = null) {
		if (!is_null($depotNumber)) {
			
		}
		$this->depotNumber = $depotNumber;
	}
	
	public function getBalance() {
		return 0;
	}
	
	public function getNumber() {
		return $this->depotNumber;
	}
}