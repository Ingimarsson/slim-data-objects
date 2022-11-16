<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\Pet\UpdatePetHistoryRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\GenericResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Update a history item of a pet")]
#[RequestDataClass(class: UpdatePetHistoryRequestData::class)]
#[ResponseDataClass(class: GenericResponseData::class, responseCodes: [200, 400, 404])]
final class UpdatePetHistoryAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = UpdatePetHistoryRequestData::fromRequest($request);

		// Your logic here

		$result = new GenericResponseData("History item $data->historyId for pet $data->id updated.");

		return JsonResponse::build($response, $result);
	}
}