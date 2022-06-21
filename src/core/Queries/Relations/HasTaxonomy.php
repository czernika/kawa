<?php

declare(strict_types=1);

namespace Kawa\Queries\Relations;

use Kawa\Queries\TermCollection;

trait HasTaxonomy
{

	/**
	 * Post type has any taxonomy
	 *
	 * @param string $taxonomy
	 * @param array $args
	 * @return TermCollection
	 */
    public function hasTaxonomy(string $taxonomy, array $args = []) : TermCollection
	{
		$taxes = wp_get_post_terms($this->id, $taxonomy::TAXONOMY, $args);
		return new TermCollection($taxonomy, $taxes);
	}
}
