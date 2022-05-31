<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Support\Traits\HasAttributes;

class Route
{
	use HasAttributes;

	public function __construct(array $attributes = [])
	{
		$this->setAttributes($attributes);
	}

	/**
	 * Set route handler
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function setHandler(callable|array $handler) : static
	{
		return $this->addAttribute('handler', HandlerDispatcher::dispatch($handler));
	}

	/**
	 * Get route handler
	 *
	 * @return callable|array
	 */
	public function getHandler() : callable|array
	{
		return $this->getAttribute('handler');
	}

	/**
	 * Set route method
	 *
	 * @param string $methods
	 * @return static
	 */
	public function setMethod(string $method) : static
	{
		return $this->addAttribute('method', $method);
	}

	/**
	 * Get route method
	 *
	 * @return string
	 */
	public function getMethod() : string
	{
		return $this->getAttribute('method');
	}
}
