<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\ResponseData\User;

use DateTimeImmutable;
use Ingimarsson\SlimDataObjects\ResponseData;

final class GetUserResponseData extends ResponseData
{
	public function __construct(
		public readonly int $id,
		public readonly string $username,
		public readonly bool $isAdmin,
		public readonly DateTimeImmutable $createdAt,
	) {}
}