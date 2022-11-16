<?php declare(strict_types=1);

use Ingimarsson\PhpValidationFun\Action;
use Ingimarsson\PhpValidationFun\Action\PostAction;
use Ingimarsson\SlimDataObjects\Middleware\ValidatorMiddleware;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->group('/pet', function (RouteCollectorProxy $group) {
	$group->get('/{id}', \Ingimarsson\SlimDataObjectsExample\Action\Pet\GetPetAction::class);
	$group->put('/{id}', \Ingimarsson\SlimDataObjectsExample\Action\Pet\UpdatePetAction::class);
	$group->delete('/{id}', \Ingimarsson\SlimDataObjectsExample\Action\Pet\DeletePetAction::class);
	$group->get('/{id}/history', \Ingimarsson\SlimDataObjectsExample\Action\Pet\GetPetHistoryAction::class);
	$group->put('/{id}/history/{historyId}', \Ingimarsson\SlimDataObjectsExample\Action\Pet\UpdatePetHistoryAction::class);
});

$app->group('/user', function (RouteCollectorProxy $group) {
	$group->post('', \Ingimarsson\SlimDataObjectsExample\Action\User\CreateUserAction::class);
	$group->get('/{id}', \Ingimarsson\SlimDataObjectsExample\Action\User\GetUserAction::class);
	$group->put('/{id}/password', \Ingimarsson\SlimDataObjectsExample\Action\User\ResetUserPasswordAction::class);
	$group->delete('/{id}', \Ingimarsson\SlimDataObjectsExample\Action\User\DeleteUserAction::class);
});

$app->addMiddleware(new ValidatorMiddleware());

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(false, true, true);

return $app;