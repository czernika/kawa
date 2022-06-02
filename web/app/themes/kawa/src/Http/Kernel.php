<?php

declare(strict_types=1);

namespace Theme\Http;

use Closure;
use Kawa\Foundation\Kernel as FoundationKernel;
use Kawa\Routing\Router;

class Kernel extends FoundationKernel
{

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
