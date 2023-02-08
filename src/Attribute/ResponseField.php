<?php

namespace Ingimarsson\SlimDataObjects\Attribute;

use Attribute;

#[Attribute]
class ResponseField {
	public function __construct(
		string $type,
	) {}
}