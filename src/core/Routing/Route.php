<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Routing\MatchesCondition\ConditionInterface;
use Kawa\Support\Traits\HasAttributes;

class Route implements RouteInterface
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
	 * @inheritDoc
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
	 * @inheritDoc
	 */
	public function getMethod() : string
	{
		return $this->getAttribute('method');
	}

	/**
	 * @inheritDoc
	 */
	public function getCondition() : ConditionInterface
	{
		return $this->getAttribute('condition');
	}

	/**
	 * @inheritDoc
	 */
	public function isSatisfied() : bool
	{
		$condition = $this->getCondition();
		return $condition->isSatisfied();
	}
}
