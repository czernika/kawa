<?php

declare(strict_types=1);

namespace Kawa\Models;

use Kawa\Queries\TaxBuilder;
use WP_Term;

/**
 * @property int $id
 * @property string $title
 */
class Taxonomy extends BaseModel
{

	public const TAXONOMY = 'category';

	public const POST_TYPES = 'post';

    public function __construct(
		protected WP_Term $term,
	) {
		$this->init();
	}

	/**
	 * Get post types assigned to this taxonomy
	 *
	 * @return array|string
	 */
	public function getPostTypes() : array|string
	{
		return static::POST_TYPES;
	}

	/**
	 * Get list of allowed properties
	 *
	 * @return array
	 */
	protected function getAllowedKeys() : array
	{
		return TaxMapper::getAllowedKeys();
	}

	/**
	 * Init object
	 *
	 * @return void
	 */
	protected function init()
	{
		foreach($this->getAllowedKeys() as $key => $property) {
			$this->$key = $this->term->$property;
		}

		$this->entity = $this->term;
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
		$builder = new TaxBuilder(static::class, ['taxonomy' => static::TAXONOMY]);
		return call_user_func_array([$builder, $name], $arguments);
	}
}
