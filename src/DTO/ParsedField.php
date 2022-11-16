<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects\DTO;

use Ingimarsson\SlimDataObjects\Enum\FieldType;

final class ParsedField
{
	public function __construct(
		public readonly string $property,
		public readonly string $type,
		public readonly ?string $description,
		public readonly FieldType $fieldType,
		public readonly ?string $name,
		public readonly array $validators,
		public readonly bool $required,
		public readonly mixed $default
	) {}
}