<?php
/**
 * WordPress query condition parameters
 * like ['is_front_page'] or ['page', 17] etc
 */

declare(strict_types=1);

namespace Kawa\Routing\MatchesCondition;

class WordPressTagCondition implements ConditionInterface
{
    public function __construct(
		private array $parameters,
	) {}

	/**
	 * @inheritDoc
	 */
	public function isSatisfied() : bool
	{
		return call_user_func(...$this->getParameters());
	}

	/**
	 * Get conditional parameters
	 *
	 * @return array
	 */
	public function getParameters() : array
	{
		return $this->parameters;
	}
}
