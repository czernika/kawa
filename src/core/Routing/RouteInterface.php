<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Routing\MatchesCondition\ConditionInterface;

interface RouteInterface
{
	/**
	 * Get WordPress condition
	 *
	 * @return ConditionInterface
	 */
	public function getCondition() : ConditionInterface;

	/**
	 * Get route method
	 *
	 * @return string
	 */
	public function getMethod() : string;

	/**
	 * Get route handler
	 *
	 * @return callable|array
	 */
	public function getHandler() : callable|array;

	/**
	 * Set route namespace
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function setNamespace(string $namespace) : static;

	/**
	 * Get route namespace
	 *
	 * @return string
	 */
	public function getNamespace() : string;

	/**
	 * Define does this route is satisfies the request
	 *
	 * @return boolean
	 */
	public function isSatisfied() : bool;
}
