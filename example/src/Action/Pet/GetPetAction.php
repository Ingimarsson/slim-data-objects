<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\Pet\GetPetRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\Pet\GetPetResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Get a single pet")]
#[RequestDataClass(class: GetPetRequestData::class)]
#[ResponseDataClass(class: GetPetResponseData::class, responseCodes: [200, 400, 404, 405])]
final class GetPetAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = GetPetRequestData::fromRequest($request);

		// Your logic here

		$result = new GetPetResponseData(
			$data->id,
			'test',
			'test',
			true,
			new \DateTimeImmutable('2022-11-16')
		);

		return JsonResponse::build($response, $result);
	}
}