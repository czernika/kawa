<?php

declare(strict_types=1);

namespace Theme\Http\Controllers;

use Kawa\Foundation\Request;
use Theme\Models\Post;

class FrontPageController extends Controller
{
	public function index(Request $request)
	{
		$posts = Post::get();
		return view('content.index', compact('posts'));
	}
}
