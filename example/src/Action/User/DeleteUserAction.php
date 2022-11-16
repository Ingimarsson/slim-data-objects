<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\User;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\User\DeleteUserRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\GenericResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Delete a user")]
#[RequestDataClass(class: DeleteUserRequestData::class)]
#[ResponseDataClass(class: GenericResponseData::class, responseCodes: [200, 400, 404, 405])]
final class DeleteUserAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = DeleteUserRequestData::fromRequest($request);

		// Your logic here

		$result = new GenericResponseData("User $data->id deleted.");

		return JsonResponse::build($response, $result);
	}
}