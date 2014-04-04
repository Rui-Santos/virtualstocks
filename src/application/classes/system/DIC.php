<?php

class DIC
{
	/**
	 * Stores all Depot instances
	 * @var Array|Depot
	 */
	private static $depotInstances = array();
	
	/**
	 * Stores all Stock instances
	 * @var Array|Stock
	 */
	private static $stockInstances = array();
	
	/**
	 * Stores all Exchange instance
	 * @param Array|Exchange
	 */
	private static $exchangeInstances = array();
	
	public static function getDepot($depotNr) {
		if(!isset(self::$depotInstances[$depotNr])) {
			self::$depotInstances[$depotNr] = new Depot($depotNr);
		}
		return self::$depotInstances[$depotNr];
	}
	
	public static function getStock($stockSymbol) {
		if(!isset(self::$stockInstances[$stockSymbol])) {
			self::$stockInstances[$stockSymbol] = new Stock($stockSymbol);
		}
		return self::$stockInstances[$stockSymbol];
	}
	
	public static function getExchange($exchangeMarket) {
		if(!isset(self::$exchangeInstances[$exchangeMarket])) {
			self::$exchangeInstances[$exchangeMarket] = new Exchange($exchangeMarket);
		}
		return self::$exchangeInstances[$exchangeMarket];
	}
	
	public static function clear() {
		self::$depotInstances = array();
		self::$stockInstances = array();
		self::$exchangeInstances = array();
	}
}