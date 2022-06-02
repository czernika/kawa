<?php
/**
 * Router facade
 */

declare(strict_types=1);

namespace Kawa\Support\Facades;

/**
 * @method static void group(string|array $attributes, string|Closure $handler)
 * @method static \Kawa\Routing\Router isFrontPage(callable|array|string $handler)
 * @method static \Kawa\Routing\Router is404(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isArchive(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isAttachment(callable|array|string $handler, int|string|array $attachment = '')
 * @method static \Kawa\Routing\Router isAuthor(callable|array|string $handler, int|string|array $author = '')
 * @method static \Kawa\Routing\Router isCategory(callable|array|string $handler, int|string|array $category = '')
 * @method static \Kawa\Routing\Router isDate(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isDay(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isHome(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isMonth(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isPage(callable|array|string $handler, int|string|array $page = '')
 * @method static \Kawa\Routing\Router isPageTemplate(callable|array|string $handler, string|array $template = '')
 * @method static \Kawa\Routing\Router isPaged(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isPostTypeArchive(callable|array|string $handler, string|array $post_type = '')
 * @method static \Kawa\Routing\Router isPrivacyPolicy(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isSearch(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isSingle(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isSingular(callable|array|string $handler, string|array $post_types = '')
 * @method static \Kawa\Routing\Router isSticky(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isTag(callable|array|string $handler, int|string|array $tag = '')
 * @method static \Kawa\Routing\Router isTax(callable|array|string $handler, string|array $tax = '')
 * @method static \Kawa\Routing\Router isTime(callable|array|string $handler)
 * @method static \Kawa\Routing\Router isYear(callable|array|string $handler)
 * @method static \Kawa\Routing\Router condition(callable|array|string $handler)
 * @method static \Illuminate\Support\Collection collection()
 * @method static array routes(string $method)
 * @method static void methods(string|array $methods, string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute get(string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute post(string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute put(string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute patch(string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute delete(string $uri, callable|array|string $handler)
 * @method static \Kawa\Routing\UriRoute options(string $uri, callable|array|string $handler)
 */
class Route extends Facade
{

	/**
	 * @inheritDoc
	 */
	protected static function getAccessor() : string
	{
		return 'router';
	}
}
