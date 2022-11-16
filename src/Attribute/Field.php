<?php

namespace Ingimarsson\SlimDataObjects\Attribute;

use Attribute;
use Ingimarsson\SlimDataObjects\Enum\FieldType;

#[Attribute]
class Field {
	public function __construct(
		FieldType $type,
		array $validators = [],
		?string $name = null,
		?string $description = null,
		?bool $required = true,
		mixed $default = null,
	) {}
}