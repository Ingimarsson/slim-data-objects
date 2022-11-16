<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class GetPetRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Url, description: "The ID of the pet")]
		public readonly int $id,
	) {}
}