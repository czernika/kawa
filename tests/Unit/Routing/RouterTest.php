<?php

declare(strict_types=1);

namespace Unit\Routing;

use Dummy\DummyAllowedMiddleware;
use Kawa\App\App;
use Kawa\Foundation\Request;
use Kawa\Routing\Contracts\HasNameContract;
use Kawa\Routing\Exceptions\InvalidRouteMethodException;
use Kawa\Routing\Exceptions\NamedRouteException;
use Kawa\Routing\Router;
use Kawa\Support\Helper;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
	/** @var Router */
	protected Router $router;

    protected function setUp(): void
	{
		$requestMock = $this->createMock(Request::class);
		$this->router = new Router($requestMock);
	}

	/** @group router */
	public function test_router_may_register_routes()
	{
		$this->assertEmpty($this->router->collection());
		$this->router->isFrontPage(fn() => 'foo');
		$this->assertNotEmpty($this->router->collection());
		$this->assertNotEmpty($this->router->routes('GET'));
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

		$routes = $this->router->routes('GET');

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

		/** @var Route */
		$route = $this->router->routes('GET')[0];
		$condition = $route->getCondition();

		$this->assertSame($params, $condition->getParameters());
	}

	/**
	 * @group router
	 * @dataProvider \Providers\HttpVerbsProvider::getVerbs
	 */
	public function test_router_uri_methods_has_correct_http_verbs($verbs)
	{
		$this->router->methods($verbs, '/foo', fn() => 'foo');

		/** @var Route */
		$route = $this->router->routes('GET')[0];
		$method = $route->getMethod();

		$this->assertSame('GET', $method);
	}

	/**
	 * @group router
	 * @dataProvider \Providers\HttpVerbsProvider::getMultipleVerbs
	 */
	public function test_router_uri_methods_may_create_multiple_routes($verbs)
	{
		$this->router->group(['foo' => 'bar'], function () use ($verbs) {
			$this->router->methods($verbs, '/foo', fn() => 'foo');

		});

		/** @var Route */
		$getRoute = $this->router->routes('GET')[0];
		$getRouteMethod = $getRoute->getMethod();
		$this->assertSame('GET', $getRouteMethod);
		$this->assertSame('bar', $getRoute->getAttribute('foo'));

		/** @var Route */
		$postRoute = $this->router->routes('POST')[0];
		$postRouteMethod = $postRoute->getMethod();
		$this->assertSame('POST', $postRouteMethod);
		$this->assertSame('bar', $postRoute->getAttribute('foo'));
	}

	/**
	 * @group router
	 * @dataProvider \Providers\CallableProvider::getUriCallables
	 */
	public function test_router_uri_methods_has_correct_methods($method, $verb)
	{
		$this->router->$method('/foo', fn() => 'foo');

		/** @var UriRoute */
		$route = $this->router->routes()[0];

		$this->assertSame($verb, $route->getMethod());
	}

	/** @group router */
	public function test_router_only_uri_routes_has_where_method()
	{
		// no exception was thrown
		$this->router->get('/foo/:bar', fn() => 'foo')->where([':bar' => 'foo']);

		$this->expectException(InvalidRouteMethodException::class);
		$this->router->isFrontPage(fn() => 'foo')->where([':bar' => 'foo']);
	}

	/** @group router */
	public function test_router_nested_routes_keeps_properties()
	{
		$this->router->group(['prefix' => '/admin'], function () {
			$this->router->get('/foo', fn() => 'foo');
			$this->router->get('/bar', fn() => 'bar'); // `/admin/bar`

			$this->router->group(['prefix' => 'user'], function () {
				$this->router->get('/foo', fn() => 'foo');
				$this->router->get('/bar', fn() => 'bar'); // `/admin/user/bar`

				$this->router->group(['prefix' => 'crazy'], function () {
					$this->router->get('/foo', fn() => 'foo');
					$this->router->get('/bar', fn() => 'bar'); // `/admin/user/crazy/bar`
				});
			});
		});

		/** @var UriRoute */
		$adminBarRoute = $this->router->routes()[1];

		/** @var UriRoute */
		$adminUserBarRoute = $this->router->routes()[3];

		/** @var UriRoute */
		$adminUserCrazyBarRoute = $this->router->routes()[5];

		$this->assertSame('/admin/bar', $adminBarRoute->getUri());
		$this->assertSame('/admin/user/bar', $adminUserBarRoute->getUri());
		$this->assertSame('/admin/user/crazy/bar', $adminUserCrazyBarRoute->getUri());
	}

	/** @group router */
	public function test_router_has_middleware()
	{
		$this->router->group(['middleware' => 'web'], function () {
			$this->router->isFrontPage(fn() => 'foo');
		});

		$route = $this->router->routes('GET')[0];

		$this->assertSame(['web'], $route->getMiddleware());
	}

	/** @group router */
	public function test_router_can_have_only_one_same_named_route()
	{
		$this->router->get('/foo', fn() => 'foo')->name('foo');
		$this->router->get('/bar', fn() => 'bar')->name('bar');

		/** @var HasNameContract */
		$route = $this->router->routes('GET')[0];
		$this->assertSame('foo', $route->getName());

		/** @var HasNameContract */
		$route = $this->router->routes('GET')[1];
		$this->assertSame('bar', $route->getName());

		$this->expectException(NamedRouteException::class);
		$this->router->get('/new', fn() => 'new')->name('bar');
	}

	/** @group router */
	public function test_router_applies_route_middleware()
	{
		$this->router->get('/foo', fn() => 'foo')->middleware(DummyAllowedMiddleware::class)->name('foo');

		/** @var UriRoute */
		$route = $this->router->routes('GET')[0];
		$middleware = $route->getMiddleware();
		$name = $route->getName();

		$this->assertTrue(in_array(DummyAllowedMiddleware::class, $middleware, true));
		$this->assertSame('foo', $name);
	}
}
