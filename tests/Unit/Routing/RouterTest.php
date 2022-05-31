<?php

declare(strict_types=1);

namespace Unit\Routing;

use Kawa\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
	/** @var Router */
	protected Router $router;

    protected function setUp(): void
	{
		$this->router = new Router();
	}

	/** @group router */
	public function test_router_may_register_routes()
	{
		$this->assertEmpty($this->router->collection());
		$this->router->isFrontPage(fn() => 'foo');
		$this->assertNotEmpty($this->router->collection());
		$this->assertNotEmpty($this->router->collection()->getRoutes('GET'));
	}

	/** @group router */
	public function test_router_may_register_group_routes()
	{
		$this->assertEmpty($this->router->collection());
		$this->router->group(['foo' => 'bar'], function () {
			$this->router->isFrontPage(fn() => 'foo');
			$this->router->isFrontPage(fn() => 'bar');
		});
		$this->router->group(['foo' => 'beta'], function () {
			$this->router->isFrontPage(fn() => 'foo');
			$this->router->isFrontPage(fn() => 'bar');
		});
		$this->assertNotEmpty($this->router->collection());

		$routes = $this->router->collection()->getRoutes('GET');

		$this->assertSame('bar', $routes[0]->getAttribute('foo'));
		$this->assertSame('bar', $routes[1]->getAttribute('foo'));
		$this->assertSame('beta', $routes[2]->getAttribute('foo'));
		$this->assertSame('beta', $routes[3]->getAttribute('foo'));
	}

	/**
	 * @group router
	 * @dataProvider \Providers\CallableProvider::getWordPressCallables
	 */
	public function test_router_wordpress_methods_has_correct_conditions($method, $params)
	{
		$this->router->$method(fn() => 'foo');

		$route = $this->router->collection()->getRoutes('GET')[0];

		$this->assertSame($params, $route->getCondition());
	}
}
