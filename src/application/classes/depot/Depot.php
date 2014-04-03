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
	
	public function withdrawMoney($withdrawSum, $currency) {
		if ($currency != Forex::FOREX_EUR) {
			$withdrawSum = round($withdrawSum / Forex::getExchange($currency, Forex::FOREX_EUR), 4);
		}
		
		if ($this->depotBalance >= $withdrawSum) {
			DB::get()->query("UPDATE vs_depot SET depot_balance = depot_balance - %d WHERE depot_number = %d", $withdrawSum, $this->depotNumber);
			$this->depotBalance -= $withdrawSum;
		} else {
			# @todo impl. error handling (not enough money)
		}
	}
	
	public function payinMoney($payinSum, $currency) {
		if ($currency != Forex::FOREX_EUR) {
			$payinSum = round($payinSum / Forex::getExchange($currency, Forex::FOREX_EUR), 4);
		}
		
		DB::get()->query("UPDATE vs_depot SET depot_balance = depot_balance + %d WHERE depot_number = %d", $payinSum, $this->depotNumber);
		$this->depotBalance += $payinSum;
	}
	
	private function load($depotNumber) {
		$depotQuery = DB::get()->query("SELECT depot_number, depot_balance FROM vs_depot WHERE depot_number = %d", $depotNumber);
		if ($depot = $depotQuery->fetch_assoc()) {
			$this->depotNumber = $depot['depot_number'];
			$this->depotBalance = $depot['depot_balance'];
		}
	}
}