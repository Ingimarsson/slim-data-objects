<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\User;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class ResetUserPasswordRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Url, description: "The ID of the user")]
		public readonly int $id,

		#[Field(type: FieldType::Body, description: "The new password")]
		public readonly string $newPassword,
	) {}
}