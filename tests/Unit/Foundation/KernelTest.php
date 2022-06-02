<?php

declare(strict_types=1);

namespace Unit\Foundation;

use DI\Container;
use Kawa\Foundation\Request;
use Kawa\Routing\Exceptions\RouteNotFoundException;
use Kawa\Routing\MatchesCondition\WordPressTagCondition;
use Kawa\Routing\Router;
use Kawa\Routing\UriRoute;
use Kawa\Routing\WordPressTagRoute;
use PHPUnit\Framework\TestCase;
use Theme\Http\Kernel;

class KernelTest extends TestCase
{
    /** @var Router */
	protected Router $router;

	/** @var Kernel */
	protected Kernel $kernel;

	/** @var Request */
	protected $requestMock;

    protected function setUp(): void
	{
		$this->requestMock = $this->createMock(Request::class);

		$this->requestMock->method('getMethod')->willReturn('GET');
		$this->requestMock->method('getPathInfo')->willReturn('/foo');

		$this->router = new Router($this->requestMock);

		$this->kernel = new Kernel(new Container(), $this->router);
	}

	/** @group kernel */
	public function test_kernel_get_correct_route()
	{
		$this->router->get('/bar', fn() => 'bar');
		$this->router->get('/foo', fn() => 'foo');

		/** @var UriRoute */
		$satisfied = $this->kernel->getSatisfiedRoute($this->requestMock);

		$this->assertSame('/foo', $satisfied->getUri());
	}

	/** @group kernel */
	public function test_kernel_get_correct_route_if_correct_uri_first()
	{
		$this->router->get('/foo', fn() => 'foo');
		$this->router->isFrontPage(fn() => 'bar');

		/** @var UriRoute */
		$satisfied = $this->kernel->getSatisfiedRoute($this->requestMock);

		$this->assertSame('/foo', $satisfied->getUri());
	}

	/** @group kernel */
	public function test_kernel_get_correct_route_if_correct_condition_first()
	{
		// Despite request returns '/foo', the front page is first
		$this->router->isFrontPage(fn() => 'bar');
		$this->router->get('/foo', fn() => 'foo');

		/** @var WordPressTagRoute */
		$satisfied = $this->kernel->getSatisfiedRoute($this->requestMock);

		/** @var WordPressTagCondition */
		$condition = $satisfied->getCondition();

		$this->assertSame(['is_front_page'], $condition->getParameters());
	}

	/** @group kernel */
	public function test_kernel_throws_exception_if_no_route_was_found()
	{
		$this->router->get('/bar', fn() => 'bar');
		$this->router->get('/boo', fn() => 'boo');

		$this->expectException(RouteNotFoundException::class);
		$this->expectExceptionMessage('Route not found');
		$satisfied = $this->kernel->getSatisfiedRoute($this->requestMock);
	}
}
