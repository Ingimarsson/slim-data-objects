<?php

namespace Ingimarsson\SlimDataObjects\Attribute;

use Attribute;

#[Attribute]
class RequestDataClass {
	public function __construct(
		string $class
	) {}
}