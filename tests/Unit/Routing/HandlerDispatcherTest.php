<?php

declare(strict_types=1);

namespace Unit\Routing;

use DI\Container;
use Kawa\App\App;
use Kawa\Routing\HandlerDispatcher;
use PHPUnit\Framework\TestCase;

class HandlerDispatcherTest extends TestCase
{
	/** @var App */
	protected App $app;

	/** @var Container */
	protected Container $container;

	protected function setUp(): void
	{
		$this->container = new Container();
		$this->app = new App($this->container);

		HandlerDispatcher::instantiate($this->app);
	}

	/**
	 * @group routing-dispatcher
	 * @dataProvider \Providers\CallableProvider::getCallableHandlers
	 */
    public function test_handler_dispatcher_return_callable($handler)
	{
		$callable = HandlerDispatcher::dispatch($handler);
		$result = $this->app->call($callable);
		$this->assertSame('foo', $result);
	}
}
