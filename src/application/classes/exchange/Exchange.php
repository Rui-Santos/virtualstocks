<?php

class Exchange
{
	/**
	 * Stores the 2-digit market ISO-code
	 * @var String
	 */
	protected $exchangeMarket;
	
	/**
	 * Stores Stock objects available on this market
	 * @var Array|Stock
	 */
	protected $exchangeStocks;
	
	public function __construct($exchangeMarket) {
		if (in_array($exchangeMarket, explode(',', Config::EXCHANGE_ACTIVE_MARKETS))) {
			$this->exchangeMarket = $exchangeMarket;
			$this->loadStocks();
		}
	}
	
	public function isOpen() {
		if (date('D') == "Sun" || date('D') == "Sat") {
			return false;
		}
		return (date('G') > 7 && date('G') < 21);
	}
	
	public function getRate($stockSymbol = null) {
		if ($this->isOpen()) {
			$yahooConn = fopen('http://download.finance.yahoo.com/d/quotes.csv?s=%40%5EDJI'. $this->prepareStatement($stockSymbol) .'&f=nsl1op&e=.csv', 'r');
			
			if (is_null($stockSymbol)) {
				$stockRates = array();
				while ($stockData = fgetcsv($yahooCon, 9999, ',') !== false) {
					if ($this->seemsLegit($stockData)) {
						$stockRates[$stockData[1]] = $stockData[2];
					}
				}
				return $stockRates;
			} else {
				$stockData = fgetcsv($yahooCon, 9999, ',');
				if ($this->seemsLegit($stockData)) {
					return $stockData[2];
				}
			}
		}
	}
	
	public function seemsLegit($stockData) {
		return true; # @todo check stock-data for sanity
	}
	
	private function prepareStatement($stockSymbol = null) {
		$preparedStatement = null;
		
		if (is_null($stockSymbol)) {
			foreach ($this->exchangeStocks as $stockSymbol => $curStock) {
				$preparedStatement .= ','. $stockSymbol .'.'. $this->exchangeMarket;
			}
		} else {
			$preparedStatement = ','. $stockSymbol .'.'. $this->exchangeMarket;
		}
		return $preparedStatement;
	}
	
	private function loadStocks() {
		$stockQuery = DB::get()->query("SELECT stock_symbol FROM vs_stock_exchange WHERE stock_exchange = '%s'", $this->exchangeMarket);
		while ($curStock = $stockQuery->fetch_assocs()) {
			$this->exchangeStocks[$curStock['stock_symbol']] = new Stock($curStock['stock_symbol']);
		}
	}
}