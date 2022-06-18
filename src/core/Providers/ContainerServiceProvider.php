<?php

declare(strict_types=1);

namespace Kawa\Providers;

use Kawa\Queries\Builder;
use Kawa\Routing\Router;

class ContainerServiceProvider extends ServiceProvider
{
	/**
	 * @inheritDoc
	 */
	public function register() : void
	{
		$this->app->singleton('router', \DI\get(Router::class));

		$this->app->factory('query', fn() => new Builder());
	}
}
