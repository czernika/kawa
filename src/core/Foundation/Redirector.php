<?php

declare(strict_types=1);

namespace Kawa\Foundation;

class Redirector
{

	/**
	 * Home url
	 *
	 * @var string
	 */
	protected static string $home = '/';

	public function __construct(
		protected Request $request,
		protected ?string $url = '/',
		protected int $status = Response::HTTP_FOUND,
		protected array $headers = [],
	) {}

	/**
	 * Rewrite response status
	 *
	 * @param integer $status
	 * @return static
	 */
	public function withStatus(int $status) : static
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * Rewrite response headers
	 *
	 * @param array $headers
	 * @return static
	 */
	public function withHeaders(array $headers) : static
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 * Set response url
	 *
	 * @param string $url
	 * @return static
	 */
	public function to(string $url) : static
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * Redirect back
	 * TODO check referer - add default option if `referer === null`
	 *
	 * @return ResponseInterface
	 */
	public function back() : ResponseInterface
	{
		$this->url = $this->request->headers->get('Referer') ?? $this->home;
		return $this->send();
	}

	/**
	 * Redirect back to home page
	 *
	 * @return ResponseInterface
	 */
	public function home() : ResponseInterface
	{
		$this->url = $this->getHomeUrl();
		return $this->send();
	}

	/**
	 * Set home url
	 *
	 * @param string $url
	 * @return static
	 */
	public function setHomeUrl(string $url) : static
	{
		static::$home = $url;
		return $this;
	}

	/**
	 * Get home url
	 *
	 * @return string
	 */
	public function getHomeUrl() : string
	{
		return static::$home;
	}

	/**
	 * Send redirect response
	 *
	 * @return ResponseInterface
	 */
    public function send() : ResponseInterface
	{
		return new RedirectResponse($this->url, $this->status, $this->headers);
	}
}
