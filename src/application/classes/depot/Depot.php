<?php

class Depot
{
	/**
	 * Stores the Depot Number (ID)
	 * @var Integer $depotNumber
	 */
	protected $depotNumber;
	
	/**
	* Stores the current balance in EUR
	* @var Float $depotBalance
	*/
	protected $depotBalance;
	
	public function __construct($depotNumber) {
		$this->load($depotNumber);
	}
	
	public function getBalance() {
		return $this->depotBalance;
	}
	
	public function getNumber() {
		return $this->depotNumber;
	}
	
	private function load($depotNumber) {
		$depotQuery = DB::get()->query("SELECT depot_number, depot_balance FROM vs_depot WHERE depot_number = %d", $depotNumber);
		if ($depot = $depotQuery->fetch_assoc()) {
			$this->depotNumber = $depot['depot_number'];
			$this->depotBalance = $depot['depot_balance'];
		}
	}
}