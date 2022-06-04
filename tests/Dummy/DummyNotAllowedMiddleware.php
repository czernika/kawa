<?php

declare(strict_types=1);

namespace Dummy;

use Closure;
use Kawa\Foundation\Request;

class DummyNotAllowedMiddleware
{
    public function handle(Request $request, Closure $next)
	{
		abort(403);
	}
}
