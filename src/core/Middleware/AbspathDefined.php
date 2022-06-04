<?php
/**
 * Throw error if 'ABSPATH' constant is not defined
 */

declare(strict_types=1);

namespace Kawa\Middleware;

use Kawa\Foundation\Request;
use Closure;
use Kawa\Routing\Middleware;

class AbspathDefined extends Middleware
{
    public function handle(Request $request, Closure $next)
	{
		abort_if(!defined('ABSPATH'), 405);

		return $next($request);
	}
}
