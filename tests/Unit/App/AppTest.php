<?php

declare(strict_types=1);

namespace Unit\App;

use DI\Container;
use Dummy\Dummy;
use Kawa\App\App;
use PHPUnit\Framework\TestCase;

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
	}

	/** @group app */
	public function test_app_has_container()
	{
		$this->assertSame($this->container, $this->app->container());
	}
}
