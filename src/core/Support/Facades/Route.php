<?php
/**
 * Router facade
 */

declare(strict_types=1);

namespace Kawa\Support\Facades;

/**
 * @method static void group(string|array $attributes, string|Closure $handler)
 * @method static \Kawa\Routing\Router isFrontPage(callable|array $handler)
 * @method static \Kawa\Routing\Router is404(callable|array $handler)
 * @method static \Kawa\Routing\Router isArchive(callable|array $handler)
 * @method static \Kawa\Routing\Router isAttachment(callable|array $handler, int|string|array $attachment = '')
 * @method static \Kawa\Routing\Router isAuthor(callable|array $handler, int|string|array $author = '')
 * @method static \Kawa\Routing\Router isCategory(callable|array $handler, int|string|array $category = '')
 * @method static \Kawa\Routing\Router isDate(callable|array $handler)
 * @method static \Kawa\Routing\Router isDay(callable|array $handler)
 * @method static \Kawa\Routing\Router isHome(callable|array $handler)
 * @method static \Kawa\Routing\Router isMonth(callable|array $handler)
 * @method static \Kawa\Routing\Router isPage(callable|array $handler, int|string|array $page = '')
 * @method static \Kawa\Routing\Router isPageTemplate(callable|array $handler, string|array $template = '')
 * @method static \Kawa\Routing\Router isPaged(callable|array $handler)
 * @method static \Kawa\Routing\Router isPostTypeArchive(callable|array $handler, string|array $post_type = '')
 * @method static \Kawa\Routing\Router isPrivacyPolicy(callable|array $handler)
 * @method static \Kawa\Routing\Router isSearch(callable|array $handler)
 * @method static \Kawa\Routing\Router isSingle(callable|array $handler)
 * @method static \Kawa\Routing\Router isSingular(callable|array $handler, string|array $post_types = '')
 * @method static \Kawa\Routing\Router isSticky(callable|array $handler)
 * @method static \Kawa\Routing\Router isTag(callable|array $handler, int|string|array $tag = '')
 * @method static \Kawa\Routing\Router isTax(callable|array $handler, string|array $tax = '')
 * @method static \Kawa\Routing\Router isTime(callable|array $handler)
 * @method static \Kawa\Routing\Router isYear(callable|array $handler)
 * @method static \Kawa\Routing\RoutesCollection collection()
 * @method static array routes(string $method)
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
