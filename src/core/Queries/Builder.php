<?php

declare(strict_types=1);

namespace Kawa\Queries;

use WP_Query;

class Builder
{

	/**
	 * Query arguments
	 *
	 * @var array
	 */
	protected array $args = [];

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
	 * Get post collection
	 *
	 * @return PostCollection
	 */
	public function get() : PostCollection
	{
		return new PostCollection(new WP_Query($this->args));
	}
}
