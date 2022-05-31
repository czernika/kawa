<?php

declare(strict_types=1);

namespace Providers;

use Dummy\Dummy;
use Dummy\InvokableDummy;

class CallableProvider
{

	/**
	 * Get list of callables
	 *
	 * @return array
	 */
    public function getCallables()
	{
		return [
			[fn() => 'foo'],
			[[Dummy::class, 'returnFoo']],
			['return_foo'],
			[new InvokableDummy()],
		];
	}

	/**
	 * Get list of callables
	 *
	 * @return array
	 */
    public function getCallableHandlers() : array
	{
		return [
			[fn() => 'foo'],
			[InvokableDummy::class],
			[[Dummy::class, 'returnFoo']],
			['\Dummy\Dummy::returnFoo'],
			['\Dummy\Dummy@returnFoo'],
		];
	}

	/**
	 * Get list of wordpress callables and conditions
	 *
	 * @return array
	 */
	public function getWordPressCallables() : array
	{
		return [
			['isFrontPage', ['is_front_page']],
			['is404', ['is_404']],
			['isArchive', ['is_archive']],
			['isAttachment', ['is_attachment', '']],
			['isAuthor', ['is_author', '']],
			['isCategory', ['is_category', '']],
			['isDate', ['is_date']],
			['isDay', ['is_day']],
			['isHome', ['is_home']],
			['isMonth', ['is_month']],
			['isPage', ['is_page', '']],
			['isPageTemplate', ['is_page_template', '']],
			['isPaged', ['is_paged']],
			['isPostTypeArchive', ['is_post_type_archive', '']],
			['isPrivacyPolicy', ['is_privacy_policy']],
			['isSearch', ['is_search']],
			['isSingle', ['is_single']],
			['isSingular', ['is_singular', '']],
			['isSticky', ['is_sticky']],
			['isTag', ['is_tag', '']],
			['isTax', ['is_tax', '']],
			['isTime', ['is_time']],
			['isYear', ['is_year']],
		];
	}
}
