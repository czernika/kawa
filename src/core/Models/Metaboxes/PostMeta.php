<?php

declare(strict_types=1);

namespace Kawa\Models\Metaboxes;

use Kawa\Models\PostType;

class PostMeta
{

	/**
	 * Post type metabox container id
	 *
	 * @var string
	 */
	private string $containerId = '';

	/**
	 * Post type id
	 *
	 * @var integer|null
	 */
	private ?int $id = null;

	public function __construct(
		private PostType $postType,
	) {}

    public function __get(string $name)
	{
		if (!$this->$name) {
			$this->$name = carbon_get_post_meta($this->getId(), $name, $this->getContainerId());
		}

		return $this->$name;
	}

	/**
	 * Get post type id
	 *
	 * @return integer
	 */
	public function getId() : int
	{
		if (null === $this->id) {
			return $this->postType->id();
		}

		return $this->id;
	}

	/**
	 * Set post type id
	 *
	 * @param integer $id
	 * @return void
	 */
	public function setId(int $id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * Get container id
	 *
	 * @return string
	 */
	public function getContainerId() : string
	{
		return $this->containerId;
	}

	/**
	 * Set post type container id
	 *
	 * @param string $id
	 * @return static
	 */
	public function setContainerId(string $id) : static
	{
		$this->containerId = $id;
		return $this;
	}
}
