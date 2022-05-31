<?php

declare(strict_types=1);

namespace Dummy;

class InvokableDummy
{
    public function __invoke() : string
	{
		return 'foo';
	}
}
