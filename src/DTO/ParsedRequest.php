<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects\DTO;

final class ParsedRequest
{
	/**
	 * @param array<string,string> $urlParams
	 * @param array<string,string> $queryParams
	 * @param array<string,string> $bodyFields
	 * @param ParsedField[] $fields
	 */
	public function __construct(
		public readonly array $urlParams,
		public readonly array $queryParams,
		public readonly array $bodyFields,
		public readonly array $fields,
	) {}
}