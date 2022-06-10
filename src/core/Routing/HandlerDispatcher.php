<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Illuminate\Support\Arr;
use Kawa\App\App;

class HandlerDispatcher
{

	/** @var App */
	protected static App $app;

	/**
	 * Instantiate dispatcher
	 *
	 * @param App $app
	 * @return void
	 */
	public static function instantiate(App $app) : void
	{
		static::$app = $app;
	}

	/**
	 * Dispatch route handler into callable format
	 *
	 * @param callable|array|string $handler
	 * @param string|null $namespace
	 * @return callable|array
	 */
    public static function dispatch(callable|array|string $handler, ?string $namespace = null) : callable|array
	{
		// It is `Controller::method` or `Controller@method`
		if (is_string($handler) && !class_exists($handler) && preg_match('/@|::/', $handler)) {
			$handler = preg_split('/@|::/', $handler, 2);

			if ($namespace) {
				$handler[0] = $namespace . $handler[0];
			}
		}

		// It is invokable controller `Controller::class`
		if (is_string($handler) && class_exists($handler)) {
			$handler = static::$app->make($handler);
		}

		return $handler;
	}

	/**
	 * Dispatch methods
	 *
	 * @param string|array $methods
	 * @return array
	 */
	public static function methods(string|array $methods) : array
	{
		if (is_string($methods) && preg_match('/\|/', $methods)) {
			$methods = explode('|', $methods);
		}

		return Arr::wrap($methods);
	}
}
