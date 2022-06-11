<?php

declare(strict_types=1);

namespace Theme\Http\Controllers;

use Kawa\Foundation\Request;

class FrontPageController extends Controller
{
	public function index(Request $request)
	{
		return view('content.index');
	}
}
