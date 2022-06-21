<?php

declare(strict_types=1);

namespace Theme\Models;

use Kawa\Models\PostType;
use Kawa\Queries\TermCollection;

class Post extends PostType
{

	/**
	 * Post has categories
	 *
	 * @return TermCollection
	 */
	public function categories() : TermCollection
	{
		return $this->hasTaxonomy(Category::class);
	}

	/**
	 * Post has tags
	 *
	 * @return TermCollection
	 */
	public function tags() : TermCollection
	{
		return $this->hasTaxonomy(Tag::class);
	}
}
