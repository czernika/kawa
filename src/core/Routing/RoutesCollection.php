<?php
/**
 * Route collection
 */

declare(strict_types=1);

namespace Kawa\Routing;

use Countable;

class RoutesCollection implements Countable
{

	/**
	 * List of app routes
	 *
	 * @var array
	 */
	protected array $routes = [];

	/**
	 * Unsorted list of all app routes
	 *
	 * @var array
	 */
	protected array $allRoutes = [];

	/**
	 * Count routes
	 *
	 * @return integer
	 */
	public function count(): int
	{
		return count($this->routes);
	}

	/**
	 * Add route into collection
	 *
	 * @param Route $route
	 * @return void
	 */
	public function addRoute(Route $route)
	{
		$method = $route->getMethod();
		$this->routes[$method][] = $route;
		$this->allRoutes[] = $route;
	}

	/**
	 * Get routes method-group or whole routes array
	 *
	 * @param string|null $method
	 * @return array
	 */
	public function getRoutes(?string $method = null) : array
	{
		if ($method && isset($this->routes[$method])) {
			return $this->routes[$method];
		}

		return $this->allRoutes;
	}
}
