<?php

declare(strict_types=1);

namespace Unit\App;

use DI\Container;
use DI\Definition\Exception\InvalidDefinition;
use Dummy\Dummy;
use Kawa\App\App;
use Kawa\Foundation\KernelInterface;
use Kawa\Routing\Router;
use PHPUnit\Framework\TestCase;
use Theme\Http\Kernel;

use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class AppTest extends TestCase
{
    /** @var App */
	protected App $app;

	/** @var Container */
	protected Container $container;

	protected function setUp(): void
	{
		$this->container = new Container();
		$this->app = new App($this->container);

		setUp();
	}

	protected function tearDown(): void
	{
		tearDown();
	}

	/** @group app */
	public function test_app_has_container()
	{
		$this->assertSame($this->container, $this->app->container());
	}

	/** @group app */
	public function test_app_should_instantiate_kernel_interface()
	{
		$this->expectException(InvalidDefinition::class);
		$this->app->boot();
	}

	/** @group app */
	public function test_app_helper_is_same_as_app()
	{
		// TODO We have to initialize KernelInterface
		$this->app->singleton(
			KernelInterface::class,
			\DI\create(Kernel::class)
				->constructor($this->container, \DI\get(Router::class)),
		);

		$this->app->boot();
		$this->assertSame(app(), $this->app);
		$this->assertInstanceOf(Dummy::class, app(Dummy::class));
	}
}
