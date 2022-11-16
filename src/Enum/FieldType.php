<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects\Enum;

enum FieldType {
	case Url;
	case Query;
	case Body;
}