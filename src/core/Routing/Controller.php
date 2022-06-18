<?php

declare(strict_types=1);

namespace Kawa\Routing;

class Controller
{
	/**
	 * Array of middleware controller groups
	 *
	 * @var array<MiddlewareController>
	 */
	protected array $middlewareGroups = [];

	/** @var MiddlewareController */
	protected MiddlewareController $middlewareController;

	/**
	 * Set middleware array
	 *
	 * @param string $middleware
	 * @return MiddlewareController
	 */
	protected function middleware(string $middleware) : MiddlewareController
	{
		$this->middlewareController = new MiddlewareController($middleware);
		$this->middlewareGroups[] = $this->middlewareController;

		return $this->middlewareController;
	}

	/**
	 * Get controller middleware groups
	 *
	 * @return array
	 */
	public function getControllerMiddleware(string $method) : array
	{
		return array_filter(
			$this->middlewareGroups,
			fn(MiddlewareController $group) => $group->appliesTo($method),
		);
	}
}
