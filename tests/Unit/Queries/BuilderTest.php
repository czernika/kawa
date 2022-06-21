<?php

declare(strict_types=1);

namespace Unit\Queries;

use Kawa\Queries\Builder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{

	/** @var Builder */
	protected Builder $builder;


	protected function setUp(): void
	{
		$this->builder = new Builder('dummy');
	}

	/** @group builder */
    public function test_builder_may_set_attributes()
	{
		$this->builder->setQueryArgument('foo', 'bar');

		$args = $this->builder->getQueryArgs();

		$this->assertArrayHasKey('foo', $args);
	}

	/** @group builder */
	public function test_builder_may_merge_attributes()
	{
		$this->builder->mergeQueryArguments(['foo' => 'bar']);

		$args = $this->builder->getQueryArgs();

		$this->assertArrayHasKey('foo', $args);
	}
}
