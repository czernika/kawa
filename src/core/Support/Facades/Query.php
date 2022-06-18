<?php

declare(strict_types=1);

namespace Kawa\Support\Facades;

class Query extends Facade
{
	/**
	 * @inheritDoc
	 */
	protected static function getAccessor() : string
	{
		return 'query';
	}
}
