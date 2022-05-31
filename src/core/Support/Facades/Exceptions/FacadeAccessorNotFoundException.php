<?php

declare(strict_types=1);

namespace Kawa\Support\Facades\Exceptions;

use Exception;

class FacadeAccessorNotFoundException extends Exception
{
    protected $message = 'Facade accessor cannot be found';
}
