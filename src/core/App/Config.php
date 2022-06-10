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
	 * @param string $path
	 * @return void
	 */
    public static function init(string $path) : void
	{
		if (self::$wasInitialized) {
			return;
		}

		$files = glob(Str::finish($path, DIRECTORY_SEPARATOR) . 'config/*.php');
		foreach ($files as $file) {
			self::$data[pathinfo($file)['filename']] = require_once $file;
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
