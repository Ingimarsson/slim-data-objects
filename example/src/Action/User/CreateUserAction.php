<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjectsExample\Action\User;

use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;
use Ingimarsson\SlimDataObjects\Attribute\ResponseDataClass;
use Ingimarsson\SlimDataObjects\Utils\JsonResponse;
use Ingimarsson\SlimDataObjectsExample\RequestData\User\CreateUserRequestData;
use Ingimarsson\SlimDataObjectsExample\ResponseData\GenericResponseData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[Path(description: "Create a new user")]
#[RequestDataClass(class: CreateUserRequestData::class)]
#[ResponseDataClass(class: GenericResponseData::class, responseCodes: [200, 400, 404, 405])]
final class CreateUserAction
{
	public function __invoke(Request $request, Response $response, array $args): Response
	{
		$data = CreateUserRequestData::fromRequest($request);

		// Your logic here

		$result = new GenericResponseData("User $data->username created.");

		return JsonResponse::build($response, $result);
	}
}