<?php

declare(strict_types=1);

namespace Kawa\View;

use Kawa\Foundation\Response;

class ResponseService
{

	/**
	 * Convert into appropriate response depends on request and content
	 *
	 * @param mixed $response
	 * @return Response
	 */
	public function toResponse($response) : Response
	{
		if (is_string($response)) {
			$response = new Response($response);
		}

		return $response;
	}
}
