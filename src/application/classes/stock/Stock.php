<?php

class Stock
{
	/**
	 * Stores the stock symbol (eg. CBK)
	 * @var String $stockSymbol
	 */
	public $stockSymbol;
	
	/**
	 * Stores the stocks short name (eg. Commerzbank)
	 * @var String $stockIdentifierName
	 */
	public $stockIdentifierName;
	
	/**
	 * Stores the full qualified name
	 * @var String $stockName
	 */
	public $stockName;
	
	/**
	 * Stores the ISIN
	 * @var String $stockISIN
	 */
	public $stockISIN;
	
	/**
	 * Stores the country-(ISO)code
	 * @var String $stockCountryISO
	 */
	public $stockCountryISO;
	
	/**
	 * Stores the stocks categoryId
	 * @var Integer $stockCategoryId
	 */
	public $stockCategoryId;

	public function __construct($stockSymbol = null) {
		if (!is_null($stockSymbol)) {
			$this->stockSymbol = $stockSymbol;
			$this->load();
		}
	}
	
	private function load($stockSymbol) {
		$stockQuery = DB::get()->query("SELECT stock_isin, stock_qualified_name, stock_short_name, stock_category, stock_country_iso FROM vs_stock WHERE stock_symbol = '%s'", $stockSymbol);
		if ($stock = $stockQuery->fetch_assoc()) {
			$this->stockSymbol = $stockSymbol;
			$this->stockIdentifierName = $stock["stock_short_name"];
			$this->stockName = $stock["stock_qualified_name"];
			$this->stockISIN = $stock["stock_isin"];
			$this->stockCategoryId = $stock["stock_category"];
			$this->stockCountryISO = $stock["stock_country_iso"];
		}
	}
}