<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class UpdatePetHistoryRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Url, description: "The ID of the pet")]
		public readonly int $id,

		#[Field(type: FieldType::Url, description: "The ID of the history item")]
		public readonly int $historyId,

		#[Field(type: FieldType::Body, description: "The employee that handled the pet")]
		public readonly string $employee,

		#[Field(type: FieldType::Body, description: "The food that was given to the pet")]
		public readonly string $food,
	) {}
}