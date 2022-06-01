<?php

declare(strict_types=1);

namespace Kawa\Routing;

use Closure;
use Illuminate\Support\Collection;
use Kawa\Foundation\Request;

class Router
{

	/**
	 * List of app routes
	 *
	 * @var RoutesCollection
	 */
	private RoutesCollection $collection;

	/**
	 * Routes group attributes
	 *
	 * @var array
	 */
	private $group = [];

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
		if (is_string($attributes)) {
			$attributes = ['prefix' => $attributes];
		}

		$this->group = $attributes;

		if (is_string($handler) && file_exists($handler)) {
			require_once $handler;
		} else {
			$handler();
		}
	}

	/**
	 * Create WordPressTagRoute for front page
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isFrontPage(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_front_page']);
	}

	/**
	 * Create WordPressTagRoute for non existing pages
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function is404(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_404']);
	}

	/**
	 * Create WordPressTagRoute for archive pages
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isArchive(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_archive']);
	}

	/**
	 * Create WordPressTagRoute for attachments
	 *
	 * @param callable|array $handler
	 * @param int|string|int[]|string[] $attachment
	 * @return static
	 */
    public function isAttachment(callable|array $handler, int|string|array $attachment = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_attachment', $attachment]);
	}

	/**
	 * Create WordPressTagRoute for authors archive
	 *
	 * @param callable|array $handler
	 * @param int|string|int[]|string[] $author
	 * @return static
	 */
    public function isAuthor(callable|array $handler, int|string|array $author = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_author', $author]);
	}

	/**
	 * Create WordPressTagRoute for categories
	 *
	 * @param callable|array $handler
	 * @param int|string|int[]|string[] $category
	 * @return static
	 */
    public function isCategory(callable|array $handler, int|string|array $category = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_category', $category]);
	}

	/**
	 * Create WordPressTagRoute for date archives
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isDate(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_date']);
	}

	/**
	 * Create WordPressTagRoute for daily archives
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isDay(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_day']);
	}

	/**
	 * Create WordPressTagRoute for blog page
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isHome(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_home']);
	}

	/**
	 * Create WordPressTagRoute for monthly archives
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isMonth(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_month']);
	}

	/**
	 * Create WordPressTagRoute for pages
	 *
	 * @param callable|array $handler
	 * @param int|string|int[]|string[] $page
	 * @return static
	 */
    public function isPage(callable|array $handler, int|string|array $page = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_page', $page]);
	}

	/**
	 * Create WordPressTagRoute for templated pages
	 *
	 * @param callable|array $handler
	 * @param string|string[] $template
	 * @return static
	 */
    public function isPageTemplate(callable|array $handler, string|array $template = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_page_template', $template]);
	}

	/**
	 * Create WordPressTagRoute for paged pages (like `/page/2`)
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isPaged(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_paged']);
	}

	/**
	 * Create WordPressTagRoute for post type archive pages
	 *
	 * @param callable|array $handler
	 * @param string|string[] $post_type
	 * @return static
	 */
    public function isPostTypeArchive(callable|array $handler, string|array $post_type = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_post_type_archive', $post_type]);
	}

	/**
	 * Create WordPressTagRoute for privacy policy page
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isPrivacyPolicy(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_privacy_policy']);
	}

	/**
	 * Create WordPressTagRoute for search page
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isSearch(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_search']);
	}

	/**
	 * Create WordPressTagRoute for single blog article page
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isSingle(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_single']);
	}

	/**
	 * Create WordPressTagRoute for post type singular pages
	 *
	 * @param callable|array $handler
	 * @param string|string[] $post_types
	 * @return static
	 */
    public function isSingular(callable|array $handler, string|array $post_types = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_singular', $post_types]);
	}

	/**
	 * Create WordPressTagRoute for sticky posts
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isSticky(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_sticky']);
	}

	/**
	 * Create WordPressTagRoute for tag archive pages
	 *
	 * @param callable|array $handler
	 * @param int|string|int[]|string[] $tag
	 * @return static
	 */
    public function isTag(callable|array $handler, int|string|array $tag = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_tag', $tag]);
	}

	/**
	 * Create WordPressTagRoute for taxonomy archive pages
	 *
	 * @param callable|array $handler
	 * @param string|string[] $tax
	 * @return static
	 */
    public function isTax(callable|array $handler, string|array $tax = '') : static
	{
		return $this->createWordPressRoute($handler, ['is_tax', $tax]);
	}

	/**
	 * Create WordPressTagRoute for timed archives
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isTime(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_time']);
	}

	/**
	 * Create WordPressTagRoute for yearly archives
	 *
	 * @param callable|array $handler
	 * @return static
	 */
    public function isYear(callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, ['is_year']);
	}

	/**
	 * Any WordPress conditional tag route
	 *
	 * @param string|array $condition
	 * @param callable|array $handler
	 * @return static
	 */
	public function condition(string|array $condition, callable|array $handler) : static
	{
		return $this->createWordPressRoute($handler, $condition);
	}

	/**
	 * Create WordPresTagRoute
	 *
	 * @param callable|array $callable
	 * @param array $params
	 * @return static
	 */
	protected function createWordPressRoute(callable|array $handler, array $params = []) : static
	{
		$route = (new WordPressTagRoute($this->group))
					->setMethod('GET')
					->setHandler($handler)
					->setCondition($params);

		$this->collection->addRoute($route);

		return $this;
	}

	/**
	 * Create URI route which supports multiple HTTP-verbs for same uri
	 *
	 * @param string|array $methods
	 * @param string $uri
	 * @param callable|array|string $handler
	 * @return static
	 */
	public function methods(string|array $methods, string $uri, callable|array|string $handler) : static
	{
		$methods = HandlerDispatcher::methods($methods);
		foreach ($methods as $method) {
			$this->createUriRoute($method, $uri, $handler);
		}

		return $this;
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
		return $this->methods('GET|HEAD', $uri, $handler);
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
		return $this->methods('POST', $uri, $handler);
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
		return $this->methods('PUT', $uri, $handler);
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
		return $this->methods('PATCH', $uri, $handler);
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
		return $this->methods('DELETE', $uri, $handler);
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
		return $this->methods('OPTIONS', $uri, $handler);
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
		$route = (new UriRoute($this->group))
					->setUri($uri)
					->setCondition($this->request)
					->setMethod($method)
					->setHandler($handler);

		$this->collection->addRoute($route);

		return $this;
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
	 * @return array
	 */
	public function routes(?string $method = null) : array
	{
		return $this->collection->getRoutes($method);
	}
}
