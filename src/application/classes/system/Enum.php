<?php

abstract class BasicEnum {
	private static $constCache = null;

	private static function getConstants() {
		if (self::$constCache === null) {
			$reflect = new ReflectionClass(get_called_class());
			self::$constCache = $reflect->getConstants();
		}

		return self::$constCache;
	}

	public static function isValidName($name, $strict = false) {
		$constants = self::getConstants();

		if ($strict) {
			return array_key_exists($name, $constants);
		}

		$keys = array_map('strtolower', array_keys($constants));
		return in_array(strtolower($name), $keys);
	}

	public static function isValidValue($value) {
		$values = array_values(self::getConstants());
		return in_array($value, $values, $strict = true);
	}
}

abstract class OrderTypes extends BasicEnum {
	const ORDER_BUY_LIMIT = 'buy_limit';
	const ORDER_SELL_LIMIT = 'sell_limit';
	const ORDER_BUY_UNLIMITED = 'buy_unlimited';
	const ORDER_SELL_UNLIMITED = 'sell_unlimited';
	const ORDER_BUY_MARKET = 'buy_market';
	const ORDER_SELL_MARKET = 'sell_market';
}