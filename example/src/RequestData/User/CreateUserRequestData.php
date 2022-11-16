<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\RequestData\User;

use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

final class CreateUserRequestData extends RequestData
{
	public function __construct(
		#[Field(type: FieldType::Body, description: "The username of the user")]
		public readonly string $username,

		#[Field(type: FieldType::Body, description: "The password of the user")]
		public readonly string $password,

		#[Field(type: FieldType::Body, description: "The admin status of the user", required: false, default: false)]
		public readonly bool $isAdmin,
	) {}
}