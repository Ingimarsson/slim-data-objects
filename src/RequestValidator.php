<?php

declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects;

use Ingimarsson\SlimDataObjects\DTO\ParsedField;
use Ingimarsson\SlimDataObjects\DTO\ParsedRequest;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Rakit\Validation\Validator;

final class RequestValidator
{
	public static function validateRequest(ParsedRequest $request): ?array
	{
		$data = self::getDataArray($request->urlParams, $request->queryParams, $request->bodyFields);
		$validators = self::getValidatorsArray($request->fields);

		//var_dump($data);

		$validator = new Validator();
		$validator->setUseHumanizedKeys(false);

		$validation = $validator->make($data, $validators);

		$validation->validate();

		// Also check for invalid field names as library does not do it.
		$errors = self::validateFieldNames($data, $validators);

		if ($validation->fails()) {
			$errors = array_merge($errors, $validation->errors()->toArray());
		}

		return $errors;
	}

	/**
	 * @param ParsedField[] $fields
	 * @return array<string,string>
	 */
	public static function getValidatorsArray(array $fields): array
	{
		$array = [];

		foreach ($fields as $field) {
			$validators = [];

			if ($field->required) {
				$validators[] = 'required';
			}

			$typeValidator = match($field->type) {
				'int' => 'numeric',
				'bool' => 'boolean',
				default => null
			};

			if ($typeValidator) {
				$validators[] = $typeValidator;
			}

			$validators = array_merge($validators, $field->validators);

			$prefix = match($field->fieldType) {
				FieldType::Url => "url",
				FieldType::Query => 'query',
				FieldType::Body => 'body'
			};

			$key = sprintf("%s.%s", $prefix, $field->name ?: $field->property);

			$array[$key] = implode("|", $validators);
		}
		return $array;
	}

	public static function getDataArray(array $urlParams, array $queryParams, array $bodyFields): array
	{
		$array = [];

		foreach ($urlParams as $key => $urlParam) {
			$array['url'][$key] = $urlParam;
		}

		foreach ($queryParams as $key => $queryParam) {
			$array['query'][$key] = $queryParam;
		}

		foreach ($bodyFields as $key => $bodyField) {
			$array['body'][$key] = $bodyField;
		}

		return $array;
	}

	public static function validateFieldNames($fields, $validators): array
	{
		$errors = [];

		foreach(['url', 'query', 'body'] as $type) {
			foreach ($fields[$type] ?? [] as $field => $value) {
				if (!array_key_exists(sprintf("%s.%s", $type, $field), $validators)) {
					$errors[sprintf("%s.%s", $type, $field)] = [
						'invalid' => 'The field is not allowed'
					];
				}
			}
		}

		return $errors;
	}
}