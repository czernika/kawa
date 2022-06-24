<?php

declare(strict_types=1);

namespace Kawa\Models\Exceptions;

use Exception;

class MetaIsNotDefinedException extends Exception
{
    protected $message = 'Metaboxes for this model is not registered';
}
