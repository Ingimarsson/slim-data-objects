<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\ResponseData\Pet;

use DateTimeImmutable;
use Ingimarsson\SlimDataObjects\ResponseData;

final class GetPetHistoryResponseData extends ResponseData
{
	public function __construct(
		public readonly int $id,
		public readonly string $employee,
		public readonly string $food,
		public readonly DateTimeImmutable $createdAt,
	) {}
}