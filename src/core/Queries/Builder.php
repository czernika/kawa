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
		$this->setQueryArgument('posts_per_page', config('query.limit', -1));
		return $this->get();
	}

	/**
	 * Get post collection
	 *
	 * @return PostCollection
	 */
	public function get() : PostCollection
	{
		return new PostCollection(new WP_Query($this->getQueryArgs()));
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
}
