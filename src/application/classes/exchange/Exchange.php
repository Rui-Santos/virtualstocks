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
		# http://download.finance.yahoo.com/d/quotes.csv?s=%40%5EDJI,GOOG&f=nsl1op&e=.csv // <- example
	}
	
	private function prepareStatement($stockSymbol = null) {
		if ($this->isOpen()) {
			if (is_null($stockSymbol)) {
				foreach ($this->exchangeStocks as $curStock) {
					
				}
			} else {
				
			}
		} else {
			
		}
	}
	
	private function loadStocks() {
		$stockQuery = DB::get()->query('SELECT stock_symbol FROM vs_stock vst LEFT JOIN vs_stock_exchange vse ON vse.stock_symbol = vst.stock_symbol WHERE .....'); # @todo need to write this code
		while ($curStock = $stockQuery->fetch_assocs()) {
			$this->exchangeStocks[$curStock['stock_symbol']] = new Stock($curStock['stock_symbol']);
		}
	}
}