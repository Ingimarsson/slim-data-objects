<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\ResponseData;

use Ingimarsson\SlimDataObjects\ResponseData;

final class GenericResponseData extends ResponseData
{
	public function __construct(
		public readonly string $message,
	) {}
}