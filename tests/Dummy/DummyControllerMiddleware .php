<?php

declare(strict_types=1);

namespace Dummy;

use Closure;
use Kawa\Foundation\Request;

class DummyControllerMiddleware
{
    public function handle(Request $request, Closure $next)
	{
		// nothing happens, request passes
		return $next($request);
	}
}
