<?php

declare(strict_types=1);

namespace Kawa\Providers;

use Kawa\App\App;

class ServiceProvider
{
    public function __construct(
		protected App $app,
	) {}
}
