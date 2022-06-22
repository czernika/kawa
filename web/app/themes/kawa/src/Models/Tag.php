<?php

declare(strict_types=1);

namespace Theme\Models;

use Kawa\Models\Taxonomy;
use Kawa\Queries\PostCollection;

class Tag extends Taxonomy
{
    public const TAXONOMY = 'post_tag';

	/**
	 * List of posts for tag
	 *
	 * @return PostCollection
	 */
	public function posts() : PostCollection
	{
		return $this->belongsToPostType(Post::class);
	}
}
