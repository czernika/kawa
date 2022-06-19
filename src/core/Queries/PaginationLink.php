<?php

declare(strict_types=1);

namespace Kawa\Queries;

use Kawa\Support\Str;

class PaginationLink
{

	/**
	 * Is it dotted separator?
	 *
	 * @var boolean
	 */
    public bool $isDot = false;

	/**
	 * Is it current page link
	 *
	 * @var boolean
	 */
	public bool $isCurrent = false;

	/**
	 * Link URL
	 *
	 * @var string|boolean
	 */
	public string|bool $link = false;

	/**
	 * Link label
	 *
	 * @var string
	 */
	public string $label = '';

	public function __construct(
		public string $html,
	)
	{
		$this->parsePaginationString($html);
	}

	/**
	 * Init object arguments from pagination string
	 *
	 * TODO refactor
	 * @todo this looks little bit ridiculous
	 * @param string $link
	 * @return void
	 */
	private function parsePaginationString(string $link)
	{
		$isLink = preg_match('~<a(.*?)href="([^"]+)"(.*?)>(.*?)</a>~', $link, $linkMatches);
		preg_match('~<span(.*?)>(.*?)</span>~', $link, $spanMatches);

		$this->isCurrent = Str::contains($link, 'current');
		$this->isLink = $isLink;
		$this->label = $isLink ? $linkMatches[4] : $spanMatches[2];
		$this->link = $isLink ? $linkMatches[2] : false;
		$this->isDot = Str::contains($link, 'dots');
	}
}
