<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Kawa\Routing\MatchesCondition\WordPressTagCondition;

class WordPressTagRoute extends Route
{

	/**
	 * Set WordPress condition
	 *
	 * @param array $parameters
	 * @return static
	 */
	public function setCondition(array $parameters) : static
	{
		return $this->addAttribute('condition', new WordPressTagCondition($parameters));
	}
}
