<?php

declare(strict_types=1);

namespace Kawa\Queries;

use Illuminate\Support\Collection;
use WP_Query;

class PostCollection extends QueryCollection
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

	/**
	 * Pagination
	 *
	 * @var Pagination|null
	 */
	protected ?Pagination $pagination = null;

	public function __construct(
		protected string $as,
		protected WP_Query $query,
		protected string $paged = 'paged',
	) {
		$this->posts = $this->mapPosts();

		$this->args = $query->query;
		$this->total = $query->found_posts;

		$this->pagination = new Pagination($query->max_num_pages, $paged);

		$this->countable = $this->getPosts();
	}

	/**
	 * Get pagination object
	 *
	 * @return void
	 */
	public function pagination()
	{
		return $this->pagination;
	}

	/**
	 * Convert WP_Post object into BaseModel objects
	 *
	 * @return Collection
	 */
	protected function mapPosts() : Collection
	{
		return collect($this->query->posts)
			->mapInto($this->as);
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
	 * Get properties
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get(string $name) : mixed
	{
		return $this->$name;
	}
}
