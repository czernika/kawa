<?php

declare(strict_types=1);

namespace Kawa\Routing\MatchesCondition;

use Kawa\Foundation\Request;
use Kawa\Routing\UriRoute;

class UriCondition implements ConditionInterface
{

	public function __construct(
		private Request $request,
		private UriRoute $route,
	) {}

	/**
	 * @inheritDoc
	 */
    public function isSatisfied(): bool
	{
		// HTTP-method is not the same
		if ($this->route->getMethod() !== $this->request->getMethod()) {
			return false;
		}

		// Direct match
		if ($this->route->getUri() === $this->request->getPathInfo()) {
			return true;
		}

		return false;
	}
}
