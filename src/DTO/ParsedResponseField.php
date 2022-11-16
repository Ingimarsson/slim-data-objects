<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects\DTO;

final class ParsedResponseField
{
	public function __construct(
		public readonly string $property,
		public readonly string $type,
		public readonly ?string $description,
	) {}
}