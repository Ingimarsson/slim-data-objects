<?php

namespace Ingimarsson\SlimDataObjects\Attribute;

use Attribute;

#[Attribute]
class Path {
	public function __construct(
		string $description = ""
	) {}
}