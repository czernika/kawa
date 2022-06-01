<?php

declare(strict_types=1);

namespace Kawa\Routing\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
    protected $message = 'Route not found';
}
