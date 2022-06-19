<?php

declare(strict_types=1);

namespace Kawa\Routing\Exceptions;

use Exception;
use Kawa\Foundation\Response;

class RouteNotFoundException extends Exception
{
    protected $message = 'Route not found';

	protected $code = Response::HTTP_NOT_FOUND;
}
