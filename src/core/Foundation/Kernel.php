<?php
/**
 * Application Kernel
 *
 * Converts upcoming request into appropriate response
 */

declare(strict_types=1);

namespace Kawa\Foundation;

use Closure;
use DI\Container;
use Kawa\App\Exceptions\HttpException;
use Kawa\Routing\Controller;
use Kawa\Routing\Exceptions\RouteNotFoundException;
use Kawa\Routing\MiddlewareController;
use Kawa\Routing\Route;
use Kawa\Routing\Router;
use Kawa\View\ResponseService;
use Kawa\View\ViewFactory;
use Throwable;
use WP_Query;

abstract class Kernel implements KernelInterface
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [];

	/**
	 * List of theme middleware
	 *
	 * @var array
	 */
	protected array $middleware = [];

	/** @var ResponseService */
	protected ResponseService $responseService;

	public function __construct(
		protected Container $container,
		protected Router $router,
	) {}

	/**
	 * @inheritDoc
	 */
	public function handle(Request $request) : void
	{
		/** @var WP_Query */
		global $wp_query;

		$resolver = $this->routes();
		$resolver($this->router);

		try {
			$route = $this->getSatisfiedRoute($request);
			$response = $this->dispatch($route, $request);
		} catch (RouteNotFoundException $e) {
			// Handle 404 or middleware exceptions
			$response = $this->throwExceptionPage($e);

			$wp_query->set_404();
			$response->setStatusCode($e->getCode());
		}

		if (!headers_sent()) {
			$response->sendHeaders();
		}

		echo $response->getContent();
	}

	/**
	 * Dispatch route and return Response instance
	 *
	 * @param Route $route
	 * @param Request $request
	 * @return ResponseInterface
	 */
	protected function dispatch(Route $route, Request $request) : ResponseInterface
	{
		$handler = $route->getHandler();
		$middleware = array_unique(array_merge(
			$route->getMiddleware(),
			$this->getControllerMiddleware($handler),
		));

		try {
			$response = $this->executeMiddleware($middleware, $request, $handler);
		} catch (HttpException $th) {
			$response = $this->throwExceptionPage($th);
		}

		return $response;
	}

	/**
	 * Get an array of controller middleware
	 *
	 * @param Closure|string|array<Controller, string> $handler
	 * @return array
	 */
	protected function getControllerMiddleware(Closure|string|array $handler) : array
	{
		if (!is_array($handler)) {
			return [];
		}

		[$controller, $method] = $handler;

		/** @var Controller */
		$controller = $this->container->make($controller);

		if (!$controller instanceof Controller) {
			return [];
		}

		$controllerMiddleware = array_map(
			fn(MiddlewareController $group) => $group->getMiddleware(),
			$controller->getControllerMiddleware($method),
		);

		return $controllerMiddleware;
	}

	/**
	 * Handle exception
	 *
	 * @param Throwable $th
	 * @return mixed
	 */
	protected function throwExceptionPage(Throwable $th) : mixed
	{
		return $this->container->call(
			[ViewFactory::class, 'render'],
			[
				'template' => config('views.templates.error', 'errors.index'),
				'context' => ['message' => $th->getMessage(), 'code' => $th->getCode()],
			],
		);
	}

	/**
	 * Execute middleware and get response
	 *
	 * @param array $middleware
	 * @param Request $request
	 * @param Closure|array|string $next
	 * @throws InvalidArgumentException if wrong middleware key was given
	 * @return ResponseInterface|string
	 */
	protected function executeMiddleware(array $middleware, Request $request, Closure|array|string $next) : ResponseInterface|string
	{
		$topMiddleware = array_shift($middleware);

		if ($topMiddleware === null) {
			$response = $this->container->call($next, [$request]);
			return $this->interceptRedirector($response);
		}

		$nextMiddleware = function ($request) use ($middleware, $next) {
			return $this->executeMiddleware($middleware, $request, $next);
		};

		$middlewareGroup = $this->getMiddleware($topMiddleware);

		if (is_array($middlewareGroup)) {
			return $this->executeMiddleware($middlewareGroup, $request, $nextMiddleware);
		}

		$middlewareHandler = $this->container->make($middlewareGroup);

		$response = $this->container->call([$middlewareHandler, 'handle'], [$request, $nextMiddleware]);
		return $this->interceptRedirector($response);
	}

	/**
	 * Intercept response and convert Redirector ro ResponseInterface
	 *
	 * @param ResponseInterface|Redirector|string $response
	 * @return ResponseInterface
	 */
	private function interceptRedirector(ResponseInterface|Redirector|string $response) : ResponseInterface
	{
		if ($response instanceof Redirector) {
			return $response->send();
		}

		if (is_string($response)) {
			return new Response($response);
		}

		return $response;
	}

	/**
	 * Get middleware by key
	 *
	 * @param string $key
	 * @return void
	 */
	public function getMiddleware(string $key)
	{
		if (array_key_exists($key, $this->middleware)) {
			return $this->middleware[$key];
		}

		return $key;
	}

	/**
	 * @inheritDoc
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}

	/**
	 * Get satisfied route according to request
	 *
	 * @param Request $request
	 * @throws RouteNotFoundException no route was satisfied
	 * @return Route
	 */
	public function getSatisfiedRoute(Request $request) : Route
	{
		$routes = $this->router->routes($request->getMethod());
		foreach ($routes as $route) {
			if ($route->isSatisfied()) {
				return $route;
			}
		}

		throw new RouteNotFoundException();
	}

	/**
	 * Fix pagination 404 error
	 *
	 * @param WP_Query $query
	 * @return void
	 */
	public function preGetPosts(WP_Query $query) : void
	{
		if (is_admin()) {
			return;
		}

		foreach ($this->paginated() as $paginated => $perPage) {
			if ('post' === $paginated && is_home()) {
				$query->set('posts_per_page', $perPage);
			}

			if ($query->is_post_type_archive($paginated)) {
				$query->set('posts_per_page', $perPage);
			}
		}
	}

	/**
	 * Resolve web routes
	 *
	 * @return Closure
	 */
	abstract protected function routes() : Closure;

	/**
	 * Get list of paginated post types
	 *
	 * @return array
	 */
	abstract protected function paginated() : array;
}
