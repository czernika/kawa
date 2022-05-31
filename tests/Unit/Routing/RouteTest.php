<?php

declare(strict_types=1);

namespace Unit\Routing;

use Kawa\Routing\WordPressTagRoute;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /** @group route */
	public function test_route_condition_is_satisfied()
	{
		$route = (new WordPressTagRoute())
					->setCondition(['is_front_page']);

		$this->assertTrue($route->isSatisfied());

		$routeWithParams = (new WordPressTagRoute())
					->setCondition(['is_page', 1]);

		$this->assertTrue($routeWithParams->isSatisfied());
	}
}
