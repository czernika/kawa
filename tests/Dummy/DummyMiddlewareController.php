<?php

declare(strict_types=1);

namespace Dummy;

use Kawa\Routing\Controller;

class DummyMiddlewareController extends Controller
{
    public function __construct()
	{
		$this->middleware(DummyNotAllowedMiddleware::class);

		$this->middleware(DummyAllowedMiddleware::class)->only('foo');

		$this->middleware(DummyControllerMiddleware::class)->except('bar');
	}

	public function index()
	{

	}

	public function foo()
	{

	}

	public function bar()
	{

	}
}
