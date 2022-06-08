<?php

declare(strict_types=1);

namespace Unit\App;

use Kawa\App\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
	/** @group config */
    public function test_config_return_value()
	{
		Config::init([
			'app' => [
				'foo' => 'bar',
			],
			'some' => ['nested' => ['example' => true]],
		]);

		$val1 = Config::get('app.foo');
		$this->assertSame('bar', $val1);

		$val2 = Config::get('some.nested.example');
		$this->assertTrue($val2);

		$val3 = Config::get('app.none');
		$this->assertNull($val3);
	}
}
