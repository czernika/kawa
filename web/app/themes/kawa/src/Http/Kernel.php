<?php

declare(strict_types=1);

namespace Theme\Http;

use Closure;
use Kawa\Foundation\Kernel as FoundationKernel;
use Kawa\Middleware\AbspathDefined;
use Kawa\Routing\Router;
use Theme\Providers\AppServiceProvider;

class Kernel extends FoundationKernel
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [
		AppServiceProvider::class,
	];

	/**
	 * List of theme middleware
	 *
	 * If you group middleware under array,
	 * it will be considered as group of middleware
	 *
	 * @var array<string, class-string|array<class-string>>
	 */
	protected array $middleware = [
		'web' => AbspathDefined::class,
	];

	/**
	 * Resolve web routes
	 *
	 * @return Closure
	 */
	protected function routes() : Closure
	{
		return function (Router $router) {
			$router->group(
				['middleware' => 'web', 'namespace' => 'Theme\\Http\\Controllers'],
				get_template_directory() . '/routes/web.php',
			);
		};
	}
}
