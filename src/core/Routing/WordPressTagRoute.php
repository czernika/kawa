<?php

declare(strict_types=1);

namespace Kawa\Routing;

class WordPressTagRoute extends Route
{

	/**
	 * Set WordPress condition
	 *
	 * @param array $condition
	 * @return static
	 */
	public function setCondition(array $condition) : static
	{
		return $this->addAttribute('condition', $condition);
	}

	/**
	 * Get WordPress condition
	 *
	 * @return void
	 */
	public function getCondition()
	{
		return $this->getAttribute('condition');
	}
}
