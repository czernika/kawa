<?php

declare(strict_types=1);

namespace Providers;

class MiddlewareMethodsProvider
{
    /**
	 * Get list of middleware methods
	 *
	 * @return array
	 */
    public function getMethodsAndResults() : array
	{
		return [
			['index',2],
			['foo',3],
			['bar',1],
		];
	}
}
