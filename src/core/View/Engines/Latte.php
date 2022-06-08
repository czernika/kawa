<?php

declare(strict_types=1);

namespace Kawa\View\Engines;

use Kawa\Support\Str;
use Latte\Engine;

class Latte implements EngineContract
{

	public function __construct(
		private Engine $latte,
	) {

	}

	/**
	 * Get Latte template engine
	 *
	 * @return Engine
	 */
	public function getEngine() : Engine
	{
		return $this->latte;
	}

	/**
	 * @inheritDoc
	 */
	public function render(string $template, array $params = [], ?string $block = null) : string
	{
		return $this->latte->renderToString($this->lattifyPath($template), $params, $block);
	}

	/**
	 * @inheritDoc
	 */
	public function output(string $template, array $params = [], ?string $block = null) : void
	{
		$this->latte->render($this->lattifyPath($template), $params, $block);
	}

	/**
	 * Convert dotted path into absolute
	 * TODO change path
	 *
	 * @param string $template
	 * @return string
	 */
	private function lattifyPath(string $template) : string
	{
		return Str::finish($this->getViewsDir(), '/') . Str::replace('.', DIRECTORY_SEPARATOR, $template) . '.latte';
	}

	/**
	 * Get views directory
	 *
	 * @return string
	 */
	private function getViewsDir() : string
	{
		return wp_normalize_path(get_template_directory() . DIRECTORY_SEPARATOR . config('views.views', '/resources/views/'));
	}
}
