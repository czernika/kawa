<?php

declare(strict_types=1);

namespace Kawa\Queries;

use WP_Term_Query;

class TaxBuilder extends Builder
{
	/**
	 * Get terms collection
	 *
	 * @param string $var
	 * @throws InvalidArgumentException
	 * @return TermCollection
	 */
	public function get() : TermCollection
	{
		$query = new WP_Term_Query($this->args);
		return new TermCollection($this->as, $query->terms, $query);
	}
}
