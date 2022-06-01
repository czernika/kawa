<?php

declare(strict_types=1);

namespace Unit\Routing\MatchConditions;

use Kawa\Foundation\Request;
use Kawa\Routing\Router;
use PHPUnit\Framework\TestCase;

class UrlConditionTest extends TestCase
{

	/**
	 * @group uri-condition
	 * @dataProvider \Providers\HttpVerbsProvider::getRoutePathInfo
	 */
	public function test_uri_condition_is_satisfied($path, $pattern)
	{
		$requestMock = $this->createMock(Request::class);

		$requestMock->method('getPathInfo')->willReturn($path);
		$requestMock->method('getMethod')->willReturn('GET');

		$router = new Router($requestMock);

		$router->get($pattern, fn() => 'bar');

		/** @var UriRoute */
		$route = $router->routes('GET')[0];

		$this->assertTrue($route->isSatisfied());
	}

	/**
	 * @group uri-condition
	 * @dataProvider \Providers\HttpVerbsProvider::getRoutePathInfo
	 */
	public function test_uri_condition_is_satisfied_with_trailing_slash_on_the_end($path, $pattern)
	{
		$requestMock = $this->createMock(Request::class);

		$requestMock->method('getPathInfo')->willReturn($path.'/');
		$requestMock->method('getMethod')->willReturn('GET');

		$router = new Router($requestMock);

		$router->get($pattern, fn() => 'bar');

		/** @var UriRoute */
		$route = $router->routes('GET')[0];

		$this->assertTrue($route->isSatisfied());
	}

}
