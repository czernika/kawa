<?php

declare(strict_types=1);

namespace Kawa\View;

use Kawa\App\App;
use Kawa\Foundation\Response;
use Kawa\View\Engines\EngineContract;

class ViewFactory
{

	/** @var EngineContract */
	protected EngineContract $engine;

	public function __construct(private App $app, private ResponseService $responseService)
	{
		$this->defineEngine();
	}

	/**
	 * Get response service
	 *
	 * @return ResponseService
	 */
	public function response() : ResponseService
	{
		return $this->responseService;
	}

	/**
	 * Define engine contract
	 *
	 * @return void
	 */
	public function defineEngine() : void
	{
		$this->engine = $this->app->get(EngineContract::class);
	}

	/**
	 * Render HTML
	 *
	 * @param string $template
	 * @param array $context
	 * @param mixed ...$params
	 * @return Response
	 */
	public function render(string $template, array $context = [], ...$params) : Response
	{
		$content = $this->engine->render($template, $context, ...$params);
		return $this->responseService->toResponse($content);
	}

	/**
	 * Echo output
	 *
	 * @param string $template
	 * @param array $context
	 * @param mixed ...$params
	 * @return void
	 */
	public function output(string $template, array $context = [], ...$params) : void
	{
		$this->engine->output($template, $context, ...$params);
	}
}
