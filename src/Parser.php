<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects;

use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseField;
use Ingimarsson\SlimDataObjects\DTO\ParsedField;
use Ingimarsson\SlimDataObjects\DTO\ParsedRequest;
use Ingimarsson\SlimDataObjects\DTO\ParsedResponseField;
use InvalidArgumentException;
use ReflectionClass;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class Parser {
	public static function parseRequest(Request $request): ?ParsedRequest
	{
		$routeContext = RouteContext::fromRequest($request);
		$route = $routeContext->getRoute();
		$callable = $route->getCallable();

		$fields = self::getFieldsFromCallable($callable);

		$arguments = $route->getArguments() ?? [];
		$queryParams = $request->getQueryParams() ?? [];
		$body = $request->getParsedBody() ?? [];

		return new ParsedRequest($arguments, $queryParams, $body, $fields);
	}

	/**
	 * Returns the metadata for each field in the callable's RequestData object that has been specified with a
	 * RequestValidator annotation on the callable.
	 *
	 * Returns null if the callable does not have the RequestValidator attribute.
	 *
	 * @param string $callable
	 * @return ParsedField[]|null
	 * @throws \ReflectionException
	 */
	public static function getFieldsFromCallable(string $callable): ?array
	{
		if (!class_exists($callable)) {
			throw new InvalidArgumentException("Class $callable does not exist.");
		}
		$reflection = new ReflectionClass($callable);

		$attributes = $reflection->getAttributes(RequestDataClass::class);

		if (count($attributes) > 1) {
			throw new InvalidArgumentException("Class $callable has multiple RequestData attributes.");
		}

		if (!$attributes) {
			return [];
		}

		$attribute = $attributes[0];

		$requestDataClass = $attribute->getArguments()['class'];

		$reflection = new ReflectionClass($requestDataClass);

		$fields = [];

		foreach ($reflection->getProperties() as $property) {

			if (count($property->getAttributes()) !== 1) {
				throw new InvalidArgumentException("Every property in a RequestDataClass object must have exactly one attribute.");
			}

			$name = $property->getName();
			$attr = $property->getAttributes()[0];
			$args = $attr->getArguments();

			$fields[] = new ParsedField(
				$name,
				$property->getType()->getName(),
				$args['description'] ?? null,
				$args['type'],
				$args['name'] ?? '',
				$args['validators'] ?? [],
				$args['required'] ?? true,
				$args['default'] ?? null
			);
		}

		return $fields;
	}

	/**
	 * @param string $callable
	 * @return ParsedResponseField[]|null
	 * @throws \ReflectionException
	 */
	public static function getResponseFieldsFromCallable(string $callable): ?array
	{
		if (!class_exists($callable)) {
			throw new InvalidArgumentException("Class $callable does not exist.");
		}
		$reflection = new ReflectionClass($callable);

		$attributes = $reflection->getAttributes(ResponseDataClass::class);

		if (count($attributes) > 1) {
			throw new InvalidArgumentException("Class $callable has multiple ResponseDataClass attributes.");
		}

		if (!$attributes) {
			return null;
		}

		$attribute = $attributes[0];

		$responseDataClass = $attribute->getArguments()['class'];
		$responseArray = $attribute->getArguments()['array'] ?? false;

		$reflection = new ReflectionClass($responseDataClass);

		$fields = [];

		foreach ($reflection->getProperties() as $property) {
			if ($property->getType()->getName() === 'array') {
				// get type from attribute
				$responseField = $property->getAttributes(ResponseField::class)[0] ?? null;

				$fields[] = new ParsedResponseField(
					$property->getName(),
					$responseField->getArguments()['type'],
					'hello',
					true
				);
			}
			else {
				$fields[] = new ParsedResponseField(
					$property->getName(),
					$property->getType()->getName(),
					'hello'
				);
			}
		}

		return $fields;
	}

	public static function getResponseDataAttributesFromCallable(string $callable): ?array
	{
		if (!class_exists($callable)) {
			throw new InvalidArgumentException("Class $callable does not exist.");
		}
		$reflection = new ReflectionClass($callable);

		$attributes = $reflection->getAttributes(ResponseDataClass::class);

		if (count($attributes) > 1) {
			throw new InvalidArgumentException("Class $callable has multiple ResponseDataClass attributes.");
		}

		if (!$attributes) {
			return null;
		}

		$attribute = $attributes[0];

		return [
			'responseCodes' => $attribute->getArguments()['responseCodes'] ?? [200],
			'array' => $attribute->getArguments()['array'] ?? false
		];
	}
}