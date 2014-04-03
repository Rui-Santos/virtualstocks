<?php

class Stock
{
	/**
	 * Stores the stock symbol (eg. CBK)
	 * @var String $stockSymbol
	 */
	protected $stockSymbol;
	
	/**
	 * Stores the stocks short name (eg. Commerzbank)
	 * @var String $stockIdentifierName
	 */
	protected $stockIdentifierName;
	
	/**
	 * Stores the full qualified name
	 * @var String $stockName
	 */
	protected $stockName;
	
	/**
	 * Stores the ISIN
	 * @var String $stockISIN
	 */
	protected $stockISIN;
	
	/**
	 * Stores the country-(ISO)code
	 * @var String $stockCountryISO
	 */
	protected $stockCountryISO;
	
	/**
	 * Stores the stocks categoryId
	 * @var Integer $stockCategoryId
	 */
	protected $stockCategoryId;

	public function __construct($stockSymbol) {
		$this->stockSymbol = $stockSymbol;
		$this->load();
	}
	
	public function getSymbol() {
		return $this->stockSymbol;
	}
	
	public function getIdentifierName() {
		return $this->stockIdentifierName;
	}
	
	public function getName() {
		return $this->stockName;
	}
	
	public function getISIN() {
		return $this->stockISIN;
	}
	
	public function getCountryISO() {
		return $this->stockCountryISO;
	}
	
	public function getCategoryId() {
		return $this->stockCategoryId;
	}
	
	public function getLatestRate($exMarket) {
		return DB::get()->query("SELECT stock_rate FROM vs_stock_rate WHERE stock_symbol = '%s' AND stock_exchange  = '%d' ORDER BY stock_timestamp DESC LIMIT 1", $this->stockSymbol, $exMarket)->fetch_value();
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