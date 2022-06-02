<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Routing\MatchesCondition\ConditionInterface;
use Kawa\Support\Str;
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
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function setHandler(callable|array|string $handler) : static
	{
		$namespace = (is_string($handler) && !class_exists($handler)) ?
						$this->getNamespace() :
						null;

		return $this->addAttribute('handler', HandlerDispatcher::dispatch($handler, $namespace));
	}

	/**
	 * @inheritDoc
	 */
	public function getHandler() : callable|array
	{
		return $this->getAttribute('handler');
	}

	/**
	 * @inheritDoc
	 */
    public function setNamespace(string $namespace) : static
	{
		return $this->addAttribute('namespace', Str::finish($namespace, '\\'));
	}

	/**
	 * @inheritDoc
	 */
	public function getNamespace() : string
	{
		return Str::finish($this->getAttribute('namespace'), '\\');
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
