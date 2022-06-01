<?php

declare(strict_types=1);

namespace Kawa\View;

use Kawa\App\App;
use Kawa\View\Engines\EngineContract;

class ViewFactory
{

	/** @var EngineContract */
	protected EngineContract $engine;

	public function __construct(private App $app)
	{
		$this->defineEngine();
	}

	/**
	 * Define engine contract
	 *
	 * @return void
	 */
	public function defineEngine() : void
	{
		$templateEngine = $this->app->get(EngineContract::class);

		$this->engine = $this->app->get($templateEngine);
	}

	/**
	 * Render HTML
	 *
	 * @param string $template
	 * @param array $context
	 * @param string|null $block
	 * @return string
	 */
	public function render(string $template, array $context = [], ?string $block = null) : string
	{
		return $this->engine->render($template, $context, $block);
	}

	/**
	 * Echo output
	 *
	 * @param string $template
	 * @param array $context
	 * @param string|null $block
	 * @return void
	 */
	public function output(string $template, array $context = [], ?string $block = null) : void
	{
		$this->engine->output($template, $context, $block);
	}
}
