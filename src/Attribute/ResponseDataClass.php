<?php

namespace Ingimarsson\SlimDataObjects\Attribute;

use Attribute;

#[Attribute]
class ResponseDataClass {
	public function __construct(
		string $class,
		bool $array = false,
		array $responseCodes = [200]
	) {}
}