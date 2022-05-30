<?php

declare(strict_types=1);

namespace Unit\App;

use DI\Container;
use Dummy\Dummy;
use Kawa\App\App;
use PHPUnit\Framework\TestCase;

class AppContainerTest extends TestCase
{
	/** @var App */
	protected App $app;

	/** @var Container */
	protected Container $container;

	protected function setUp(): void
	{
		$this->container = new Container();
		$this->app = new App($this->container);
	}

	/** @group app-container */
    public function test_app_container_may_bind_and_resolve_instance()
	{
		$this->app->set('foo', 'bar');
		$this->assertTrue($this->app->has('foo'));
		$this->assertSame('bar', $this->app->get('foo'));
	}

	/** @group app-container */
    public function test_app_container_may_bind_instance()
	{
		$dummy = $this->app->make(Dummy::class);
		$this->assertInstanceOf(Dummy::class, $dummy);
	}

	/** @group app-container */
    public function test_app_container_make_method_resolve_new_instance_every_time()
	{
		$dummy = $this->app->make(Dummy::class);
		$dummy2 = $this->app->make(Dummy::class);
		$this->assertNotSame($dummy, $dummy2);
	}

	/** @group app-container */
    public function test_app_container_get_method_resolve_same_instance_every_time()
	{
		$dummy = $this->app->get(Dummy::class);
		$dummy2 = $this->app->get(Dummy::class);
		$this->assertSame($dummy, $dummy2);
	}

	/**
	 * @group app-container
	 * @dataProvider \Providers\CallableProvider::getCallables()
	 */
    public function test_app_container_call_method_resolve_callable($callable)
	{
		$result = $this->app->call($callable);
		$this->assertSame('foo', $result);
	}
}
