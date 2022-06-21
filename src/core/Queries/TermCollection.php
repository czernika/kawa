<?php

declare(strict_types=1);

namespace Kawa\Queries;

use Illuminate\Support\Collection;
use WP_Term_Query;

class TermCollection extends QueryCollection
{
	/**
	 * List of term collection
	 *
	 * @var Collection
	 */
	protected Collection $terms;

	public function __construct(
		protected string $as,
		protected array $list,
		protected ?WP_Term_Query $query = null,
	) {
		$this->terms = $this->mapTerms();

		$this->countable = $this->getTerms();
	}

	/**
	 * Convert WP_Post object into BaseModel objects
	 *
	 * @return Collection
	 */
	protected function mapTerms() : Collection
	{
		return collect($this->list)
			->mapInto($this->as);
	}

	/**
	 * Get list of posts
	 *
	 * @return array
	 */
	public function getTerms() : array
	{
		return $this->terms->all();
	}
}
