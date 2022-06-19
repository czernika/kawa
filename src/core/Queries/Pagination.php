<?php

declare(strict_types=1);

namespace Kawa\Queries;

use ArrayIterator;
use Illuminate\Support\Arr;
use IteratorAggregate;
use Traversable;

class Pagination implements IteratorAggregate
{

	/**
	 * Current page number
	 *
	 * @var integer
	 */
	protected int $current = 0;

	/**
	 * List of pagination links
	 *
	 * @var array
	 */
	protected array $pages = [];

	public function __construct(
		protected float $max,
		protected string $paged = 'paged',
	) {
		$this->current = max(1, get_query_var($this->paged));
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->pages() ?? []);
	}

	/**
	 * Get pagination links when calling object directly
	 *
	 * @return string
	 */
	public function __toString() : string
	{
		return $this->links();
	}

	/**
	 * Get paginated links
	 *
	 * @param string $args
	 * @return string
	 */
	public function links(string|array $args = '') : string
	{
		return paginate_links(array_merge(
			[
				'total' => $this->max,
				'type' => 'plain',
				'current' => $this->current,
			],
			Arr::wrap($args),
		));
	}

	/**
	 * Get paginated links
	 *
	 * @param string $args
	 * @return string
	 */
	public function list(string|array $args = '') : string
	{
		return $this->links(array_merge(Arr::wrap($args), ['type' => 'list']));
	}

	/**
	 * Get list of pagination pages
	 *
	 * @param string $args
	 * @return array|null
	 */
	public function pages(string|array $args = '') : ?array
	{
		return $this->buildPages($args);
	}

	/**
	 * Get pagination pages to build
	 *
	 * @param string $args
	 * @return array|null
	 */
	protected function buildPages(string|array $args = '') : ?array
	{
		$links = paginate_links(array_merge(
			Arr::wrap($args),
			[
				'total' => $this->max,
				'type' => 'array',
				'current' => $this->current,
			],
		));

		if ($links) {
			$links = array_map(fn($link) => new PaginationLink($link), $links);
		}

		return $links;
	}
}
