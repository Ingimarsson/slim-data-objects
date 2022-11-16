<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class UpdatePetRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Url, description: "The ID of the pet")]
		public readonly int $id,

		#[Field(type: FieldType::Body, description: "The name of the pet")]
		public readonly string $name,

		#[Field(type: FieldType::Body, description: "The category of the pet")]
		public readonly string $category,

		#[Field(type: FieldType::Body, description: "The availability of the pet", required: false, default: true)]
		public readonly bool $available,
	) {}
}