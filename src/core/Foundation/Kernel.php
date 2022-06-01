<?php
/**
 * Application Kernel
 *
 * Converts upcoming request into appropriate response
 */

declare(strict_types=1);

namespace Kawa\Foundation;

use DI\Container;
use Kawa\Routing\Exceptions\RouteNotFoundException;
use Kawa\Routing\Route;
use Kawa\Routing\Router;

class Kernel implements KernelInterface
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [];

	public function __construct(protected Container $container, protected Router $router)
	{

	}

	/**
	 * @inheritDoc
	 */
	public function handle(Request $request) : void
	{
		// TODO for now let it be here, resolve later
		require_once get_template_directory() . '/routes/web.php';

		try {
			$route = $this->getSatisfiedRoute($request);
			$response = $this->dispatch($route, $request);
		} catch (RouteNotFoundException $e) {
			// Handle 404
			$response = '404!';
		}

		echo $response;
	}

	/**
	 * Dispatch route and return Response instance
	 *
	 * @param Route $route
	 * @param Request $request
	 * @return void
	 */
	protected function dispatch(Route $route, Request $request)
	{
		$handler = $route->getHandler();

		// Handle middleware here

		$content = $this->container->call($handler);

		return $content;
	}

	/**
	 * @inheritDoc
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}

	/**
	 * Get satisfied route according to request
	 *
	 * @param Request $request
	 * @throws RouteNotFoundException no route was satisfied
	 * @return Route
	 */
	public function getSatisfiedRoute(Request $request) : Route
	{
		$routes = $this->router->routes($request->getMethod());
		foreach ($routes as $route) {
			if ($route->isSatisfied()) {
				return $route;
			}
		}

		throw new RouteNotFoundException();
	}
}
