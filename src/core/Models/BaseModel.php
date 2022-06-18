<?php

declare(strict_types=1);

namespace Kawa\Models;

use WP_Post;

class BaseModel
{

	/**
	 * List of array keys to swap
	 *
	 * @var array
	 */
	private array $keys = [
		'id' => 'ID',
		'title' => 'post_title',
		'name' => 'post_title',
	];

	public function __construct(
		protected WP_Post $post,
	) {}

	/**
	 * Get post ID
	 *
	 * @return string
	 */
	public function id() : string
	{
		return $this->id;
	}

	/**
	 * Get post title
	 *
	 * @return string
	 */
	public function title() : string
	{
		return $this->title;
	}

	/**
	 * Get post title (alias for `title()` method)
	 *
	 * @return string
	 */
	public function name() : string
	{
		return $this->title;
	}

	public function __get(string $name) : mixed
	{
		return $this->getPostProperty($name);
	}

	/**
	 * Get property from post object
	 *
	 * @param string $name
	 * @return mixed
	 */
	protected function getPostProperty(string $name) : mixed
	{
		if ($this->hasKey($name)) {
			$name = $this->getKey($name);
		}

		return $this->post->$name;
	}

	/**
	 * Get list of allowed properties
	 *
	 * @return array
	 */
	protected function getAllowedKeys() : array
	{
		return $this->keys;
	}

	/**
	 * Does property exists as allowed
	 *
	 * @param string $key
	 * @return boolean
	 */
	protected function hasKey(string $key) : bool
	{
		return array_key_exists($key, $this->getAllowedKeys());
	}

	/**
	 * Get value from allowed properties
	 *
	 * @param string $key
	 * @return string|null
	 */
	protected function getKey(string $key) : ?string
	{
		if ($this->hasKey($key)) {
			return $this->getAllowedKeys()[$key];
		}

		return null;
	}
}
