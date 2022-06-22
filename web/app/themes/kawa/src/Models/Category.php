<?php

declare(strict_types=1);

namespace Theme\Models;

use Kawa\Models\Taxonomy;
use Kawa\Queries\PostCollection;

class Category extends Taxonomy
{

	/**
	 * List of posts for category
	 *
	 * @return PostCollection
	 */
	public function posts() : PostCollection
	{
		return $this->belongsToPostType(Post::class);
	}
}
