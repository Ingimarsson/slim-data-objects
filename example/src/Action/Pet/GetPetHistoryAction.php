<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\Pet\GetPetHistoryRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\Pet\GetPetHistoryResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Get the history for a pet")]
#[RequestDataClass(class: GetPetHistoryRequestData::class)]
#[ResponseDataClass(class: GetPetHistoryResponseData::class, array: true, responseCodes: [200, 400, 404])]
final class GetPetHistoryAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = GetPetHistoryRequestData::fromRequest($request);

		// Your logic here

		$result = [
			new GetPetHistoryResponseData(
				$data->id,
				'test',
				'test',
				new \DateTimeImmutable('2022-11-16')
			),
		];

		return JsonResponse::build($response, $result);
	}
}