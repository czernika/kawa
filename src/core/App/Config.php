<?php

declare(strict_types=1);

namespace Kawa\App;

use Illuminate\Support\Arr;
use Kawa\Support\Str;

class Config
{

	/**
	 * Configuration data
	 *
	 * @var array
	 */
	private static array $data = [];

	/**
	 * Define does config was defined or not
	 *
	 * @var boolean
	 */
	private static bool $wasInitialized = false;

	/**
	 * Initialize config data
	 *
	 * @param string|array $path
	 * @return void
	 */
    public static function init(string|array $data) : void
	{
		if (self::$wasInitialized) {
			return;
		}

		if (is_string($data)) {
			$files = glob(Str::finish($data, DIRECTORY_SEPARATOR) . 'config/*.php');
			foreach ($files as $file) {
				self::$data[pathinfo($file)['filename']] = require_once $file;
			}
		}

		if (is_array($data)) {
			self::$data = $data;
		}

		self::$wasInitialized = true;
	}

	/**
	 * Get data from config
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public static function get(string $key, $default = null) : mixed
	{
		return Arr::get(self::data(), $key, $default);
	}

	/**
	 * Get config data
	 *
	 * @return array
	 */
	public static function data() : array
	{
		return self::$data;
	}
}
