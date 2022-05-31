<?php

declare(strict_types=1);

namespace Kawa\Routing\MatchesCondition;

interface ConditionInterface
{
	/**
	 * Define does this route satisfied the request
	 *
	 * @return boolean
	 */
    public function isSatisfied() : bool;
}
