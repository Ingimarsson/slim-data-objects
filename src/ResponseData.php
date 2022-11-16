<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects;

abstract class ResponseData
{
	public function toJson(): string
	{
		return json_encode($this);
	}
}