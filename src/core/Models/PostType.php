<?php

declare(strict_types=1);

namespace Kawa\Models;

use Kawa\Queries\Builder;
use WP_Post;
use WP_User;

class PostType extends BaseModel
{

	/**
	 * Post type slug
	 */
	protected const POST_TYPE = 'post';

	/**
	 * Model ID
	 *
	 * @var integer
	 */
	protected int $id;

	/**
	 * Model title
	 *
	 * @var string
	 */
	protected string $title;

	/**
	 * Post type url
	 *
	 * @var string
	 */
	protected string $url;

	/**
	 * Post type guid
	 *
	 * @var string
	 */
	protected string $guid;

	/**
	 * Model author
	 *
	 * @var WP_User
	 */
	protected WP_User $author;

	/**
	 * PostType content
	 *
	 * @var string
	 */
	protected string $content;

	/**
	 * PostType preview
	 *
	 * @var string
	 */
	protected string $excerpt;

	/**
	 * When model was created
	 *
	 * @var string
	 */
	protected string $created_at;

	/**
	 * When model was updated
	 *
	 * @var string
	 */
	protected string $updated_at;

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

	/**
	 * Get post type id
	 *
	 * @return int
	 */
	public function id() : int
	{
		return $this->id;
	}

	/**
	 * Get post type title
	 *
	 * @return string
	 */
	public function title() : string
	{
		return $this->title;
	}

	/**
	 * Get post type guid
	 *
	 * @return string
	 */
	public function guid() : string
	{
		return $this->guid;
	}

	/**
	 * Get post type url
	 *
	 * @return string
	 */
	public function url() : string
	{
		return $this->url;
	}

	/**
	 * Get post type content
	 *
	 * @return string
	 */
	public function content() : string
	{
		return $this->content;
	}

	/**
	 * Get post type excerpt
	 *
	 * @return string
	 */
	public function excerpt() : string
	{
		return $this->excerpt;
	}

	/**
	 * Get post type author object
	 *
	 * @return WP_User
	 */
	public function author() : WP_User
	{
		return $this->author;
	}

	/**
	 * Get  post type created at date
	 *
	 * @return string
	 */
	public function createdAt() : string
	{
		return $this->created_at;
	}

	/**
	 * Get post type updated at date
	 *
	 * @return string
	 */
	public function updatedAt() : string
	{
		return $this->updated_at;
	}

	/**
	 * Call query builder methods
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public static function __callStatic(string $name, array $arguments) : mixed
	{
		$builder = new Builder(['post_type' => static::POST_TYPE]);
		return call_user_func_array([$builder, $name], $arguments);
	}
}
