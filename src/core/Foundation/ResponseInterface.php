<?php
/**
 * Symfony foundation methods
 * which were used in application
 */

declare(strict_types=1);

namespace Kawa\Foundation;

interface ResponseInterface
{
	/**
	 * @inheritDoc
	 */
	public function setStatusCode(int $code, string $text = null) : static;

	/**
	 * @inheritDoc
	 */
	public function sendHeaders() : static;

	/**
	 * @inheritDoc
	 */
	public function getContent() : string|false;
}
