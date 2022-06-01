<?php

declare(strict_types=1);

namespace Unit\Routing;

use Kawa\Foundation\Request;
use Kawa\Routing\Router;
use Kawa\Routing\UriRoute;
use PHPUnit\Framework\TestCase;

class UriRouteTest extends TestCase
{

	/** @var Router */
	protected Router $router;

    protected function setUp(): void
	{
		$requestMock = $this->createMock(Request::class);
		$requestMock->expects($this->any())->method('getPathInfo')->willReturn('/foo');
		$requestMock->expects($this->any())->method('getMethod')->willReturn('GET');

		$this->router = new Router($requestMock);
	}

    /** @group uri-route */
	public function test_uri_route_has_correct_uri()
	{
		$this->router->methods('GET', '/foo', fn() => 'bar');

		$this->router->group('/admin', function () {
			$this->router->methods('GET', '/foo', fn() => 'bar');
		});

		/** @var UriRoute */
		$route = $this->router->routes('GET')[0];
		$prefixedRoute = $this->router->routes('GET')[1];

		$this->assertSame('/foo', $route->getUri());
		$this->assertSame('/admin/foo', $prefixedRoute->getUri());
	}

	/** @group uri-route */
	public function test_uri_route_is_satisfied()
	{
		$this->router->methods('GET', '/foo', fn() => 'bar');

		/** @var UriRoute */
		$route = $this->router->routes('GET')[0];

		$this->assertTrue($route->isSatisfied());
	}
}
