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
	
	public function addStock(Stock $stock, $stockAmount = 1) {
		$stockQuery = DB::get()->query("SELECT COUNT(*) AS exists FROM vs_depot_stock WHERE depot_number = %d AND stock_symbol = '%s'", $this->depotNumber, $stock->getSymbol());
		if($stockQuery->fetch_value() == 1) {
			DB::get()->query("UPDATE vs_depot_stock SET stock_amount = stock_amount + %d WHERE stock_symbol = '%s' AND depot_number = %d", $stockAmount, $stock->getSymbol(), $this->depotNumber);
		} else {
			DB::get()->query("INSERT INTO vs_depot_stock(depot_number, stock_symbol, stock_amount) VALUES(%d, '%s', %d)", $this->depotNumber, $stock->getSymbol(), $stockAmount);
		}
	}

	public function withdrawMoney($withdrawSum, $currency) {
		if ($currency != Forex::FOREX_EUR) {
			$withdrawSum = round($withdrawSum / Forex::getExchange($currency, Forex::FOREX_EUR), 4);
		}
		
		if ($this->depotBalance >= $withdrawSum) {
			DB::get()->query("UPDATE vs_depot SET depot_balance = depot_balance - %d WHERE depot_number = %d", $withdrawSum, $this->depotNumber);
			$this->depotBalance -= $withdrawSum;
		} else {
			throw new DepotException('You do not have enough money to perform this action!');
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