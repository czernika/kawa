<?php

declare(strict_types=1);

namespace Kawa\Queries;

use InvalidArgumentException;
use WP_Query;

class PostTypeBuilder extends Builder
{

	/**
	 * Get all posts types
	 *
	 * @return PostCollection
	 */
	public function all() : PostCollection
	{
		return $this->paginate(config('query.limit', -1));
	}

	/**
	 * Take specific amount of post type objects
	 *
	 * @param integer $perPage
	 * @return PostCollection
	 */
	public function take(int $perPage) : PostCollection
	{
		return $this->paginate($perPage);
	}

	/**
	 * Alias for `take()` method
	 *
	 * @param string|integer $perPage
	 * @return PostCollection
	 */
	protected function paginate(string|int $perPage) : PostCollection
	{
		$this->setQueryArgument('posts_per_page', $perPage);
		return $this->get();
	}

	/**
	 * Get post collection
	 *
	 * @param string $var
	 * @throws InvalidArgumentException
	 * @return PostCollection
	 */
	public function get(string $var = 'paged') : PostCollection
	{
		if (!in_array($var, ['page', 'paged'], true)) {
			throw new InvalidArgumentException(sprintf('Invalid argument for `get()` method - `page` or `paged` supported, %s found', $var));
		}

		$this->mergeQueryArguments([
			'paged' => max(1, get_query_var($var)),
		]);
		return new PostCollection($this->as, new WP_Query($this->getQueryArgs()), $var);
	}
}
