<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects\Utils;

use Psr\Http\Message\ResponseInterface as Response;

final class JsonResponse
{
	public static function build(Response $response, mixed $data): Response
	{
		$response->getBody()->write(json_encode($data));

		return $response->withHeader('Content-Type', 'application/json');
	}
}