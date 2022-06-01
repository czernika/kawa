<?php

declare(strict_types=1);

namespace Providers;

class HttpVerbsProvider
{

	/**
	 * Get list of all possible verbs for route method
	 *
	 * @return array
	 */
    public function getVerbs() : array
	{
		return [
			['GET'],
			[['GET']],
			['GET|POST'],
			[['GET', 'POST']],
		];
	}

	/**
	 * Get list of verbs
	 * when route method should create multiple routes
	 *
	 * @return array
	 */
	public function getMultipleVerbs() : array
	{
		return [
			['GET|POST'],
			[['GET', 'POST']],
		];
	}

	/**
	 * Get real path info for request and route regex pattern
	 *
	 * @return array
	 */
	public function getRoutePathInfo() : array
	{
		return [
			['/foo', '/foo'],
			['/%d0%bf%d1%80%d0%b8%d0%b2%d0%b5%d1%82-%d0%bc%d0%b8%d1%80', '/привет-мир'],
			['/posts/some-post', '/posts/:slug'],
			['/posts/some-post', '/posts/:string'],
			['/posts/some-post', '/posts/:slug?'],
			['/posts/12', '/posts/:id'],
			['/posts/12', '/posts/:number'],
			['/posts/12.6', '/posts/:float'],
			['/posts/cfd2acbe-df56-11ec-9d64-0242ac120002', '/posts/:uuid'],
			['/posts/2022-12-27', '/posts/:date'],
			['/posts/0', '/posts/:bool'],
			['/posts/1', '/posts/:bool'],
			['/posts/true', '/posts/:bool'],
			['/posts/false', '/posts/:bool'],
			['/posts/foo', '/:all'],
			['/posts/foo', '/posts/:any'],
		];
	}
}
