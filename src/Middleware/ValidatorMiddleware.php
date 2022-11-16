<?php

namespace Ingimarsson\SlimDataObjects\Middleware;

use Ingimarsson\SlimDataObjects\Parser;
use Ingimarsson\SlimDataObjects\RequestValidator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;

class ValidatorMiddleware implements MiddlewareInterface
{
	public function process(Request $request, Handler $handler): Response {
		$parsedRequest = Parser::parseRequest($request);

		$validation = RequestValidator::validateRequest($parsedRequest);

		if (!$validation) {
			$response = $handler->handle($request);
			return $response;
		}
		else {
			$response = new Response();
			$response->getBody()->write(json_encode([
				'message' => 'Input validation failed',
				'errors' => $validation,
			]));

			return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
		}
	}
}