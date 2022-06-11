<?php
/**
 * Simple route based on request path info
 */

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Foundation\Request;
use Kawa\Routing\Contracts\HasNameContract;
use Kawa\Routing\Contracts\HasUriContract;
use Kawa\Routing\MatchesCondition\UriCondition;

class UriRoute extends Route implements HasUriContract, HasNameContract
{

	/**
	 * @inheritDoc
	 */
	public function setUri(string $uri) : static
	{
		$prefix = $this->getAttribute('prefix') ?: '';
		return $this->addAttribute('uri', $prefix . $uri);
	}

	/**
	 * @inheritDoc
	 */
	public function getUri() : string
	{
		return $this->getAttribute('uri');
	}

	/**
	 * Set route name
	 *
	 * @param string $name
	 * @return static
	 */
	public function setName(string $name) : static
	{
		return $this->addAttribute('name', $name);
	}

	/**
	 * Get route name
	 *
	 * @return string|null
	 */
	public function getName() : ?string
	{
		return $this->getAttribute('name');
	}

	/**
	 * @inheritDoc
	 */
	public function where(array $regex) : void
	{
		/** @var UriCondition */
		$condition = $this->getCondition();
		$condition->addPattern($regex);
	}

	/**
	 * Set Uri condition
	 *
	 * @param Request $request
	 * @return static
	 */
	public function setCondition(Request $request) : static
	{
		return $this->addAttribute('condition', new UriCondition($request, $this));
	}
}
