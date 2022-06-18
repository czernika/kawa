<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Illuminate\Support\Arr;

class MiddlewareController
{
	/**
	 * List of methods-middleware only-relation
	 *
	 * @var string[]
	 */
	protected array $only = [];

	/**
	 * List of methods-middleware except-relation
	 *
	 * @var string[]
	 */
	protected array $except = [];

	public function __construct(
		protected string $middleware,
	) {}

	/**
	 * Set middleware to be applied only for these methods
	 *
	 * @param string|array $methods
	 * @return void
	 */
	public function only(string|array $methods) : void
	{
		$this->only = Arr::wrap($methods);
	}

	/**
	 * Set middleware to be applied everywhere except these methods
	 *
	 * @param string|array $methods
	 * @return void
	 */
	public function except(string|array $methods) : void
	{
		$this->except = Arr::wrap($methods);
	}

	/**
	 * Get middleware
	 *
	 * @return array
	 */
	public function getMiddleware() : array
	{
		return Arr::wrap($this->middleware);
	}

	/**
	 * Define does this method can be applied to this middleware
	 *
	 * @param string $method
	 * @return boolean
	 */
	public function appliesTo(string $method) : bool
	{
		if (in_array($method, $this->except, true)) {
			return false;
		}

		if (empty($this->only)) {
			return true;
		}

		return in_array($method, $this->only, true);
	}
}
