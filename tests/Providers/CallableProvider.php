<?php

declare(strict_types=1);

namespace Providers;

use Dummy\Dummy;

class CallableProvider
{

	/**
	 * Get list of callables
	 *
	 * @return array
	 */
    public function getCallables()
	{
		return [
			[fn() => 'foo'],
			[[Dummy::class, 'returnFoo']],
			['return_foo'],
		];
	}
}
