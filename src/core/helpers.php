<?php
/**
 * Kawa Framework application helpers
 *
 * Set of useful functions for app development
 *
 * @package Kawa
 */

use Kawa\Support\Helper;

if (!function_exists('app')) {

	/**
	 * Get container instance or binded value if passed
	 *
	 * @param string|null $key
	 * @return mixed
	 */
	function app(?string $key = null) : mixed
	{
		return Helper::app($key);
	}
}
