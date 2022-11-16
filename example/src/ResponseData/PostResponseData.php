<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\ResponseData;

use DateTimeImmutable;

final class PostResponseData
{
	public function __construct(
		public readonly int $id,
		public readonly string $username,
		public readonly ?bool $isAdmin,
		public readonly ?DateTimeImmutable $createdAt,
	) {}
}