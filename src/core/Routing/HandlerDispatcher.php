<?php

declare(strict_types=1);

namespace Kawa\Routing;

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
	 * @return callable|array
	 */
    public static function dispatch(callable|array|string $handler) : callable|array
	{
		// It is `Controller::method` or `Controller@method`
		if (is_string($handler) && !class_exists($handler) && preg_match('/@|::/', $handler)) {
			$handler = preg_split('/@|::/', $handler, 2);
		}

		// It is invokable controller `Controller::class`
		if (is_string($handler) && class_exists($handler)) {
			$handler = static::$app->make($handler);
		}

		return $handler;
	}
}
