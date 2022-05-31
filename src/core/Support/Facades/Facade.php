<?php

declare(strict_types=1);

namespace Kawa\Support\Facades;

use Kawa\App\App;
use Kawa\Support\Facades\Exceptions\FacadeAccessorNotFoundException;

class Facade
{
	/** @var App */
    protected static App $app;

	/**
	 * Instantiate Facade App
	 *
	 * @param App $app
	 * @return void
	 */
	public static function instantiate(App $app) : void
	{
		static::$app = $app;
	}

	/**
	 * Resolve accessor
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return void
	 */
	public static function __callStatic(string $method, array $arguments)
	{
		$accessor = static::getAccessor();
		return static::$app->call([$accessor, $method], $arguments);
	}

	/**
	 * Get accessor object key
	 *
	 * @throws FacadeAccessorNotFoundException
	 * @return string
	 */
	protected static function getAccessor() : string
	{
		throw new FacadeAccessorNotFoundException;
	}
}
