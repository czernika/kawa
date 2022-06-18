<?php

declare(strict_types=1);

namespace Kawa\Queries;

use ArrayIterator;
use Countable;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Kawa\Models\PostType;
use Traversable;
use WP_Query;

class PostCollection implements Countable, IteratorAggregate
{

	/**
	 * Total amount of posts
	 *
	 * @var integer|null
	 */
	protected ?int $total = null;

	/**
	 * User query arguments
	 *
	 * @var array|null
	 */
	protected ?array $args = null;

	/**
	 * List of queries posts
	 *
	 * @var Collection
	 */
	protected Collection $posts;

	public function __construct(
		protected WP_Query $query
	) {
		$this->posts = $this->mapPosts();

		$this->args = $query->query;

		$this->total = $this->count();
	}

	/**
	 * Convert WP_Post object into BaseModel objects
	 *
	 * @param string $as
	 * @return Collection
	 */
	protected function mapPosts(string $as = PostType::class) : Collection
	{
		return collect($this->query->posts)
			->mapInto($as);
	}

	/**
	 * Get list of posts
	 *
	 * @return array
	 */
	public function getPosts() : array
	{
		return $this->posts->all();
	}

	/**
	 * Merge list of posts
	 *
	 * @param array $posts
	 * @return void
	 */
	public function mergePosts(array $posts) : void
	{
		$this->posts = array_merge($this->getPosts(), $posts);
	}

	/**
	 * Get WP_Query object
	 *
	 * @return WP_Query
	 */
	public function getQuery() : WP_Query
	{
		return $this->query;
	}

	/**
	 * Count total amount of posts
	 *
	 * @return integer
	 */
	public function count(): int
	{
		return count($this->getPosts());
	}

	/**
	 * Make collection iterable
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->getPosts());
	}
}
