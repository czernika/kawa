<?php

declare(strict_types=1);

namespace Kawa\Queries\Relations;

use Kawa\Queries\PostCollection;
use WP_Query;

trait BelongsToPostType
{
	/**
	 * Taxonomy belongs to post type
	 *
	 * @param string $postType
	 * @return PostCollection
	 */
	public function belongsToPostType(string $postType, array $args = []) : PostCollection
	{
		$query = ['tax_query' => [['taxonomy' => static::TAXONOMY, 'field' => 'id','terms' => $this->id]]];
		return new PostCollection($postType, new WP_Query(array_merge($query, $args)));
	}
}
