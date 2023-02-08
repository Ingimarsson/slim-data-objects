<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\ResponseData\Pet;

use DateTimeImmutable;
use Ingimarsson\SlimDataObjects\Attribute\ResponseField;
use Ingimarsson\SlimDataObjectsExample\ResponseData\Pet\Object\PetHistory;
use Ingimarsson\SlimDataObjects\ResponseData;

final class GetPetResponseData extends ResponseData
{
	public function __construct(
		public readonly int $id,
		public readonly string $name,
		public readonly string $category,
		public readonly bool $available,
		public readonly DateTimeImmutable $createdAt,

		/** @var PetHistory[] */
		#[ResponseField(type: PetHistory::class)]
		public readonly array $history,

		/** @var string[] */
		#[ResponseField(type: 'string')]
		public readonly array $nicknames
	) {}
}