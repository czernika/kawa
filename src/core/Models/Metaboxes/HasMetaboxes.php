<?php

declare(strict_types=1);

namespace Kawa\Models\Metaboxes;

use Carbon_Fields\Container\Container;
use Kawa\Models\PostType;
use Kawa\Models\Taxonomy;

trait HasMetaboxes
{
	protected bool $hasMetaboxes = true;

	/**
	 * Get post model metaboxes
	 *
	 * @return void
	 */
	abstract public function metaboxes();

	/**
	 * Make metabox container
	 *
	 * @param string $title
	 * @param string $id
	 * @return Container
	 */
	protected function container(string $title, string $id) : Container
	{
		return $this->makeContainer($title, $id);
	}

	/**
	 * Create metabox container depends on object type
	 *
	 * @param string $title
	 * @param string $id
	 * @return Container
	 */
	private function makeContainer(string $title, string $id) : Container
	{
		return Container::make($this->getContainerType(), $title, $id);
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private function getContainerType() : string
	{
		if (static::class instanceof PostType) {
			return 'post_meta';
		}

		if (static::class instanceof Taxonomy) {
			return 'term_meta';
		}

		return 'post_meta';
	}
}
