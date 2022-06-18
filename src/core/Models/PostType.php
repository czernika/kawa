<?php

declare(strict_types=1);

namespace Kawa\Models;

use WP_Post;
use WP_User;

class PostType extends BaseModel
{

	/**
	 * Model ID
	 *
	 * @var integer|null
	 */
	protected ?int $id = null;

	/**
	 * Model title
	 *
	 * @var string|null
	 */
	protected ?string $title = null;

	/**
	 * Post type url
	 *
	 * @var string|null
	 */
	protected ?string $url = null;

	/**
	 * Post type guid
	 *
	 * @var string|null
	 */
	protected ?string $guid = null;

	/**
	 * Model author
	 *
	 * @var WP_User|null
	 */
	protected ?WP_User $author = null;

	/**
	 * PostType content
	 *
	 * @var string|null
	 */
	protected ?string $content = null;

	/**
	 * PostType preview
	 *
	 * @var string|null
	 */
	protected ?string $excerpt = null;

	/**
	 * When model was created
	 *
	 * @var string|null
	 */
	protected ?string $created_at = null;

	public function __construct(
		protected WP_Post $post,
	) {
		$this->init();
	}

	/**
	 * Init object
	 *
	 * @return void
	 */
	protected function init()
	{
		foreach(PostMapper::getAllowedKeys() as $key => $property) {
			$this->$key = $this->post->$property;
		}

		$this->author = get_user_by('id', $this->post->post_author);
		$this->url = get_permalink($this->post);
	}
}
