<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\Pet;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\Pet\DeletePetRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\GenericResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Delete a pet")]
#[RequestDataClass(class: DeletePetRequestData::class)]
#[ResponseDataClass(class: GenericResponseData::class, responseCodes: [200, 400, 404])]
final class DeletePetAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = DeletePetRequestData::fromRequest($request);

		// Your logic here

		$result = new GenericResponseData("Pet $data->id deleted.");

		return JsonResponse::build($response, $result);
	}
}