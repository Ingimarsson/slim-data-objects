<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects;

use Ingimarsson\SlimDataObjects\Enum\FieldType;
use ReflectionClass;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class RequestData {
	public static function fromRequest(Request $request): static
	{
		$parsedRequest = Parser::parseRequest($request);

		$object = [];

		foreach ($parsedRequest->fields as $field) {
			$value = match ($field->fieldType) {
				FieldType::Url => $parsedRequest->urlParams[$field->property] ?? null,
				FieldType::Query => $parsedRequest->queryParams[$field->property] ?? null,
				FieldType::Body => $parsedRequest->bodyFields[$field->property] ?? null,
			};

			if ($value !== null) {
				$value = match ($field->type) {
					'int' => (int)$value,
					'bool' => (bool)$value,
					'DateTimeImmutable' => new \DateTimeImmutable($value),
					default => $value
				};
			}
			else {
				$value = $field->default;
			}

			$object[$field->property] = $value;
		}

		$r = new ReflectionClass(static::class);

		return $r->newInstanceArgs($object);
	}
}