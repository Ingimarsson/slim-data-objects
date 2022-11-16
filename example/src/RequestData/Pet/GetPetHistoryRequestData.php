<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class GetPetHistoryRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Url, description: "The ID of the pet")]
		public readonly int $id,

		#[Field(type: FieldType::Query, description: "The offset in the results", required: false, default: 0)]
		public readonly int $offset,

		#[Field(type: FieldType::Query, description: "The number of results to return", required: false, default: 10)]
		public readonly int $limit,
	) {}
}