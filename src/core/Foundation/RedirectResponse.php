<?php

declare(strict_types=1);

namespace Kawa\Foundation;

use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class RedirectResponse extends HttpFoundationRedirectResponse implements ResponseInterface
{

}
