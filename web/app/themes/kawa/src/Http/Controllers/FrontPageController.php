<?php

declare(strict_types=1);

namespace Theme\Http\Controllers;

use Kawa\Foundation\Request;
use Kawa\Support\Facades\Query;

class FrontPageController extends Controller
{
	public function index(Request $request)
	{
		$posts = Query::query(['post_type' => 'post'])->get();
		return view('content.index', compact('posts'));
	}
}
