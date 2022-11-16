<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\User;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\User\GetUserRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\User\GetUserResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Get a single user")]
#[RequestDataClass(class: GetUserRequestData::class)]
#[ResponseDataClass(class: GetUserResponseData::class, responseCodes: [200, 400, 404, 405])]
final class GetUserAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = GetUserRequestData::fromRequest($request);

		// Your logic here

		$result = new GetUserResponseData(
			$data->id,
			'test',
			true,
			new \DateTimeImmutable('2022-11-16')
		);

		return JsonResponse::build($response, $result);
	}
}