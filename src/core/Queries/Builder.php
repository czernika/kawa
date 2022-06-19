<?php

declare(strict_types=1);

namespace Kawa\Queries;

use WP_Query;

class Builder
{

	public function __construct(
		protected array $args = [],
	) {}

	/**
	 * Create unique query
	 *
	 * @param array $query
	 * @return static
	 */
	public function query(array $query) : static
	{
		$this->args = $query;
		return $this;
	}

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
6
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
	 * @return PostCollection
	 */
	public function get(string $var = 'paged') : PostCollection
	{
		$this->mergeQueryArguments([
			'paged' => max(1, get_query_var($var)),
		]);
		return new PostCollection(new WP_Query($this->getQueryArgs()), $var);
	}

	/**
	 * Get query arguments
	 *
	 * @return array
	 */
	protected function getQueryArgs() : array
	{
		return $this->args;
	}

	/**
	 * Set query argument
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	protected function setQueryArgument(string $key, $value) : void
	{
		$this->args[$key] = $value;
	}

	/**
	 * Merge query arguments
	 *
	 * @param array $args
	 * @return void
	 */
	protected function mergeQueryArguments(array $args) : void
	{
		$this->args = array_merge($this->args, $args);
	}
}
