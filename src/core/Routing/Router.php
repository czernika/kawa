<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kawa\Foundation\Request;
use Kawa\Foundation\Response;
use Kawa\Routing\Contracts\HasNameContract;
use Kawa\Routing\Exceptions\InvalidRouteMethodException;
use Kawa\Routing\Exceptions\NamedRouteException;
use Kawa\Support\Str;
use Kawa\Foundation\RedirectResponse;

class Router
{

	/**
	 * List of app routes
	 *
	 * @var RoutesCollection
	 */
	private RoutesCollection $collection;

	/**
	 * Current route we're working on
	 *
	 * @var RouteInterface
	 */
	private RouteInterface $currentRoute;

	/**
	 * Routes group attributes
	 *
	 * @var array
	 */
	private array $attributes = [];

	/**
	 * List of named routes
	 *
	 * @var array
	 */
	private array $namedRoutes = [];

	public function __construct(private Request $request)
	{
		$this->collection = new RoutesCollection();
	}

	/**
	 * Create route group properties
	 *
	 * @param string|array $attributes
	 * @param string|Closure $handler
	 * @return void
	 */
	public function group(string|array $attributes, string|Closure $handler) : void
	{
		$this->mergeAttributes($attributes);

		if (is_string($handler) && file_exists($handler)) {
			require_once $handler;
		} else {
			$handler();
		}
	}

	/**
	 * Merge group attributes
	 *
	 * @param string|array $attributes
	 * @return void
	 */
	private function mergeAttributes(string|array $attributes) : void
	{
		if (is_string($attributes)) {
			$attributes = ['prefix' => $attributes];
		}

		array_walk($attributes, function (&$value, $key) {
			if (!in_array($key, ['prefix', 'name', 'namespace', 'middleware'], true)) {
				return $value;
			}

			if ('middleware' === $key) {
				$middleware = array_key_exists($key, $this->attributes) ? $this->attributes[$key] : [];
				$value = array_merge(Arr::wrap($middleware), Arr::wrap($value));
			}

			if (array_key_exists($key, $this->attributes) && 'middleware' !== $key) {
				$value = match ($key) {
					'prefix' => Str::start($value, '/'),
					'namespace' => Str::start($value, '\\'),
					default => $value,
				};
				$value = $this->attributes[$key] . $value;
			}

			return $value;
		});

		$this->attributes = array_merge($this->attributes, $attributes);
	}

	/**
	 * Create WordPressTagRoute for front page
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isFrontPage(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_front_page']);
	}

	/**
	 * Create WordPressTagRoute for non existing pages
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function is404(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_404']);
	}

	/**
	 * Create WordPressTagRoute for archive pages
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isArchive(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_archive']);
	}

	/**
	 * Create WordPressTagRoute for attachments
	 *
	 * @param callable|array|string $handler
	 * @param int|string|int[]|string[] $attachment
	 * @return static
	 */
    public function isAttachment(callable|array|string $handler, int|string|array $attachment = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_attachment', $attachment]);
	}

	/**
	 * Create WordPressTagRoute for authors archive
	 *
	 * @param callable|array|string $handler
	 * @param int|string|int[]|string[] $author
	 * @return static
	 */
    public function isAuthor(callable|array|string $handler, int|string|array $author = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_author', $author]);
	}

	/**
	 * Create WordPressTagRoute for categories
	 *
	 * @param callable|array|string $handler
	 * @param int|string|int[]|string[] $category
	 * @return static
	 */
    public function isCategory(callable|array|string $handler, int|string|array $category = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_category', $category]);
	}

	/**
	 * Create WordPressTagRoute for date archives
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isDate(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_date']);
	}

	/**
	 * Create WordPressTagRoute for daily archives
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isDay(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_day']);
	}

	/**
	 * Create WordPressTagRoute for blog page
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isHome(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_home']);
	}

	/**
	 * Create WordPressTagRoute for monthly archives
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isMonth(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_month']);
	}

	/**
	 * Create WordPressTagRoute for pages
	 *
	 * @param callable|array|string $handler
	 * @param int|string|int[]|string[] $page
	 * @return static
	 */
    public function isPage(callable|array|string $handler, int|string|array $page = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_page', $page]);
	}

	/**
	 * Create WordPressTagRoute for templated pages
	 *
	 * @param callable|array|string $handler
	 * @param string|string[] $template
	 * @return static
	 */
    public function isPageTemplate(callable|array|string $handler, string|array $template = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_page_template', $template]);
	}

	/**
	 * Create WordPressTagRoute for paged pages (like `/page/2`)
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isPaged(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_paged']);
	}

	/**
	 * Create WordPressTagRoute for post type archive pages
	 *
	 * @param callable|array|string $handler
	 * @param string|string[] $post_type
	 * @return static
	 */
    public function isPostTypeArchive(callable|array|string $handler, string|array $post_type = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_post_type_archive', $post_type]);
	}

	/**
	 * Create WordPressTagRoute for privacy policy page
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isPrivacyPolicy(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_privacy_policy']);
	}

	/**
	 * Create WordPressTagRoute for search page
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isSearch(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_search']);
	}

	/**
	 * Create WordPressTagRoute for single blog article page
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isSingle(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_single']);
	}

	/**
	 * Create WordPressTagRoute for post type singular pages
	 *
	 * @param callable|array|string $handler
	 * @param string|string[] $post_types
	 * @return static
	 */
    public function isSingular(callable|array|string $handler, string|array $post_types = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_singular', $post_types]);
	}

	/**
	 * Create WordPressTagRoute for sticky posts
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isSticky(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_sticky']);
	}

	/**
	 * Create WordPressTagRoute for tag archive pages
	 *
	 * @param callable|array|string $handler
	 * @param int|string|int[]|string[] $tag
	 * @return static
	 */
    public function isTag(callable|array|string $handler, int|string|array $tag = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_tag', $tag]);
	}

	/**
	 * Create WordPressTagRoute for taxonomy archive pages
	 *
	 * @param callable|array|string $handler
	 * @param string|string[] $tax
	 * @return static
	 */
    public function isTax(callable|array|string $handler, string|array $tax = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_tax', $tax]);
	}

	/**
	 * Create WordPressTagRoute for timed archives
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isTime(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_time']);
	}

	/**
	 * Create WordPressTagRoute for yearly archives
	 *
	 * @param callable|array|string $handler
	 * @return static
	 */
    public function isYear(callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_year']);
	}

	/**
	 * Any WordPress conditional tag route
	 *
	 * @param string|array $condition
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function condition(string|array $condition, callable|array|string $handler) : static
	{
		return $this->createWordPressRoute($handler, Arr::wrap($condition));
	}

	/**
	 * Create WordPresTagRoute
	 *
	 * @param callable|array|string $callable
	 * @param array $params
	 * @return static
	 */
	protected function createWordPressRoute(callable|array|string $handler, array $params = []) : static
	{
		$this->currentRoute = (new WordPressTagRoute($this->attributes))
					->setMethod('GET')
					->setHandler($handler)
					->setCondition($params);

		$this->setCurrentRoute();

		return $this;
	}

	/**
	 * Create URI route which supports multiple HTTP-verbs for same uri
	 *
	 * @param string|array $methods
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return void
	 */
	public function methods(string|array $methods, string $uri, callable|array|string $handler) : void
	{
		$methods = HandlerDispatcher::methods($methods);
		foreach ($methods as $method) {
			$this->createUriRoute($method, $uri, $handler);
		}
	}

	/**
	 * Create GET route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function get(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('GET', $uri, $handler);
	}

	/**
	 * Create POST route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function post(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('POST', $uri, $handler);
	}

	/**
	 * Create PUT route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function put(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('PUT', $uri, $handler);
	}

	/**
	 * Create PATCH route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function patch(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('PATCH', $uri, $handler);
	}

	/**
	 * Create DELETE route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function delete(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('DELETE', $uri, $handler);
	}

	/**
	 * Create OPTIONS route
	 *
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function options(string $uri, callable|array|string $handler) : static
	{
		return $this->createUriRoute('OPTIONS', $uri, $handler);
	}

	/**
	 * Get view template for simple template
	 *
	 * @param string $uri
	 * @param string $views
	 * @param array $context
	 * @param mixed ...$extra
	 * @return static
	 */
	public function view(string $uri, string $views, array $context = [], ...$extra) : static
	{
		return $this->get($uri, fn() => view($views, $context, ...$extra));
	}

	/**
	 * Create redirect route
	 *
	 * @param string $from
	 * @param string $to
	 * @param int $status
	 * @param array $headers
	 * @return static
	 */
	public function redirect(string $from, string $to, int $status = Response::HTTP_FOUND, array $headers = []) : static
	{
		return $this->get($from, fn() => redirect($to, $status, $headers));
	}

	/**
	 * Create permanent redirect
	 *
	 * @param string $from
	 * @param string $to
	 * @param array $headers
	 * @return static
	 */
	public function permanentRedirect(string $from, string $to, array $headers = []) : static
	{
		return $this->redirect($from, $to, Response::HTTP_MOVED_PERMANENTLY, $headers);
	}

	/**
	 * Add custom regex pattern to a route
	 *
	 * @param array $regex
	 * @throws InvalidRouteMethodException if current route type is invalid
	 * @return void
	 */
	public function where(array $regex) : void
	{
		if (!$this->currentRoute instanceof UriRoute) {
			throw new InvalidRouteMethodException(sprintf('`where()` method supported only by `Kawa\Routing\UriRoute`, %s given', get_class($this->currentRoute)));
		}

		$this->currentRoute->where($regex);
	}

	/**
	 * Set route name
	 *
	 * @param string $name
	 * @return static
	 */
	public function name(string $name) : static
	{
		if (!$this->currentRoute instanceof HasNameContract) {
			throw new InvalidRouteMethodException(sprintf('`name()` method supported only by `Kawa\Routing\Contracts\HasNameContract` routes, %s given', get_class($this->currentRoute)));
		}

		$this->addNamedRoute($name);

		$this->currentRoute->setName($name);
		return $this;
	}

	/**
	 * Add middleware to a route
	 *
	 * @param array|string $middleware
	 * @return static
	 */
	public function middleware(array|string $middleware) : static
	{
		$this->currentRoute->setMiddleware($middleware);
		return $this;
	}

	/**
	 * Create simple uri route
	 *
	 * @param string $method
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	protected function createUriRoute(string $method, string $uri, callable|array|string $handler) : static
	{
		$this->currentRoute = (new UriRoute($this->attributes))
					->setUri($uri)
					->setCondition($this->request)
					->setMethod($method)
					->setHandler($handler);

		$this->setCurrentRoute();

		return $this;
	}

	/**
	 * Add route into collection
	 *
	 * @return void
	 */
	protected function setCurrentRoute() : void
	{
		$this->collection->addRoute($this->currentRoute);
	}

	/**
	 * Add named route to an array
	 *
	 * @param string $name
	 * @throws NamedRouteException if route name already has been taken
	 * @return void
	 */
	protected function addNamedRoute(string $name) : void
	{
		if (array_key_exists($name, $this->getNamedRoutes())) {
			throw new NamedRouteException(sprintf('Route named %s already exists', $name));
		}

		$this->namedRoutes[$name] = $this->currentRoute;
	}

	/**
	 * Get list of named routes
	 *
	 * @return array
	 */
	public function getNamedRoutes() : array
	{
		return $this->namedRoutes;
	}

	/**
	 * Set route namespace
	 *
	 * @param string $namespace
	 * @return void
	 */
	public function namespace(string $namespace)
	{
		return $this->currentRoute->setNamespace($namespace);
	}

	/**
	 * Get routes as collection
	 *
	 * @param string|null $method
	 * @return Collection
	 */
	public function collection(?string $method = null) : Collection
	{
		return collect($this->routes($method));
	}

	/**
	 * Get all app routes
	 *
	 * @param string|null $method
	 * @return array<Route>
	 */
	public function routes(?string $method = null) : array
	{
		return $this->collection->getRoutes($method);
	}
}
