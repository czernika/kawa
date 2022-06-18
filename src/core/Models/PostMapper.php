<?php

declare(strict_types=1);

namespace Kawa\Models;

class PostMapper
{
    /**
	 * List of array keys to swap
	 *
	 * @var array
	 */
	private static array $keys = [
		'id' => 'ID',
		'title' => 'post_title',
		'guid' => 'guid',
		'content' => 'post_content',
		'excerpt' => 'post_excerpt',
		'created_at' => 'post_date',
		'updated_at' => 'post_modified',
	];

	/**
	 * Get allowed keys
	 *
	 * @return array
	 */
	public static function getAllowedKeys() : array
	{
		return self::$keys;
	}
}
