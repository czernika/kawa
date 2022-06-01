<?php

declare(strict_types=1);

namespace Providers;

class HttpVerbsProvider
{
    public function getVerbs() : array
	{
		return [
			['GET'],
			[['GET']],
			['GET|POST'],
			[['GET', 'POST']],
		];
	}

	public function getMultipleVerbs() : array
	{
		return [
			['GET|POST'],
			[['GET', 'POST']],
		];
	}
}
