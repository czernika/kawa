<?php

declare(strict_types=1);

namespace Unit\Routing;

use Dummy\DummyAllowedMiddleware;
use Dummy\DummyMiddlewareController;
use Dummy\DummyNotAllowedMiddleware;
use Kawa\Routing\UriRoute;
use PHPUnit\Framework\TestCase;

class MiddlewareControllerTest extends TestCase
{
	/** @group middleware-controller */
    public function test_route_applies_controller_middleware_to_every_route()
	{
		$indexRoute = (new UriRoute())->setHandler([DummyMiddlewareController::class, 'index']);

		$indexRoute->setMiddleware(DummyAllowedMiddleware::class);
		$this->assertTrue(in_array(DummyAllowedMiddleware::class, $indexRoute->getMiddleware(), true));

		$middlewareController = (new DummyMiddlewareController())->getControllerMiddleware('index')[0];
		$this->assertTrue(in_array(DummyNotAllowedMiddleware::class, $middlewareController->getMiddleware(), true));

		$indexRoute = (new UriRoute())->setHandler([DummyMiddlewareController::class, 'foo']);

		$middlewareController = (new DummyMiddlewareController())->getControllerMiddleware('foo')[0];
		$this->assertTrue(in_array(DummyNotAllowedMiddleware::class, $middlewareController->getMiddleware(), true));
	}

	/**
	 * @dataProvider \Providers\MiddlewareMethodsProvider::getMethodsAndResults
	 * @group middleware-controller
	 */
    public function test_route_applies_controller_middleware_for_specified_methods(string $method, int $total)
	{
		(new UriRoute())->setHandler([DummyMiddlewareController::class, $method]);

		$indexMiddleware = (new DummyMiddlewareController())->getControllerMiddleware($method);
		$this->assertTrue($total === count($indexMiddleware));
	}
}
