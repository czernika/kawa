<?php

declare(strict_types=1);

namespace Unit\Routing;

use DI\Container;
use Dummy\DummyNotAllowedMiddleware;
use Kawa\App\Exceptions\HttpException;
use Kawa\Foundation\Request;
use Kawa\Routing\UriRoute;
use PHPUnit\Framework\TestCase;

class MiddlewareTest extends TestCase
{
	/** @var Route */
	protected UriRoute $route;

	/** @var Container */
	protected Container $container;

    protected function setUp(): void
	{
		$this->container = new Container();
		$this->route = (new UriRoute(['middleware' => DummyNotAllowedMiddleware::class]));
	}

	/** @group middleware */
	public function test_middleware_applies()
	{
		$middleware = $this->route->getMiddleware()[0];
		$this->expectException(HttpException::class);
		$this->container->call([$middleware, 'handle'], [$this->createMock(Request::class), fn() => 'foo']);
	}
}
