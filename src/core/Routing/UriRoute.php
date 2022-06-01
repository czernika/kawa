<?php
/**
 * Simple route based on request path info
 */

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Foundation\Request;
use Kawa\Routing\Contracts\HasUriContract;
use Kawa\Routing\MatchesCondition\UriCondition;

class UriRoute extends Route implements HasUriContract
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
