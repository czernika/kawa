<?php

declare(strict_types=1);

namespace Unit\Routing;

use Kawa\Foundation\Request;
use Kawa\Routing\Router;
use Kawa\Routing\WordPressTagRoute;
use PHPUnit\Framework\TestCase;

class WordPressTagRouteTest extends TestCase
{
    /** @group wordpress-route */
	public function test_wordpress_route_condition_is_satisfied()
	{
		$route = (new WordPressTagRoute())
					->setCondition(['is_front_page']);

		$this->assertTrue($route->isSatisfied());

		$routeWithParams = (new WordPressTagRoute())
					->setCondition(['is_page', 1]);

		$this->assertTrue($routeWithParams->isSatisfied());
	}

	/** @group wordpress-route */
	public function test_wordpress_route_may_set_namespace()
	{
		$requestMock = $this->createMock(Request::class);
		$router = new Router($requestMock);

		$router->isFrontPage(fn() => 'bar')->namespace('Custom');

		/** @var UriRoute */
		$route = $router->routes('GET')[0];

		$namespace = $route->getNamespace();

		$this->assertSame('Custom\\', $namespace);
	}
}
