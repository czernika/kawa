<?php

declare(strict_types=1);

namespace Kawa\Models;

class TaxMapper
{
    /**
	 * List of array keys to swap
	 *
	 * @var array
	 */
	private static array $keys = [
		'id' => 'term_id',
		'title' => 'name',
	];

	/**
	 * Get allowed keys
	 *
	 * @return array
	 */
	public static function getAllowedKeys() : array
	{
		return self::$keys;
	}
}
