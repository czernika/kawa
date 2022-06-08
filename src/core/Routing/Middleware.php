<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Closure;
use Kawa\Foundation\Request;
use Kawa\Foundation\Response;
use Kawa\View\ViewFactory;
use Kawa\App\Exceptions\HttpException;

abstract class Middleware
{

	public function __construct(
		protected ViewFactory $view,
	) {}

	/**
	 * Handle incoming request
	 *
	 * @param RequestInterface $request
	 * @param Closure $next
	 * @throws HttpException
	 * @return Response|string
	 */
	abstract public function handle(Request $request, Closure $next);

	/**
	 * Abort request and show error page
	 * TODO add params for default template
	 *
	 * @param integer $code
	 * @param string|null $message
	 * @return void
	 */
	protected function showErrorPage(int $code, ?string $message = null)
	{
		$message = $message ?? Response::$statusTexts[$code];
		return $this->view->render(config('views.templates.error', 'errors.index'), compact('message', 'code'))
					->setStatusCode($code);
	}
}
