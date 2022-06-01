<?php

declare(strict_types=1);

namespace Kawa\View\Engines;

interface EngineContract
{
	/**
	 * Renders HTML
	 *
	 * @param string $template
	 * @param array $params
 	 * @param string|block $block
	 * @return string
	 */
	public function render(string $template, array $params = [], ?string $block = null) : string;

	/**
	 * Echo output
	 *
	 * @param string $template
	 * @param array $params
	 * @param string|block $block
	 * @return void
	 */
	public function output(string $template, array $params = [], ?string $block = null) : void;
}
