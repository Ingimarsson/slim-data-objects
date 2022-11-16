<?php declare(strict_types=1);

namespace Ingimarsson\SlimDataObjects;

use cebe\openapi\Reader;
use cebe\openapi\spec\PathItem;
use cebe\openapi\Writer;
use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\Utils\HttpResponseCodes;
use ReflectionClass;
use Slim\App;

/**
 * Builds an OpenAPI specification from a \Slim\App instance.
 */
final class DocBuilder {
	protected const DEFAULT_TEMPLATE = 'openapi.json';

	protected App $app;
	protected string $template;

	/**
	 * Constructs the OpenAPI builder. If a template is specified, the output JSON will be built on top of it.
	 *
	 * @param App $app The Slim app instance
	 * @param string|null $template (optional) Path to a OpenAPI JSON file
	 */
	public function __construct(App $app, ?string $template = null) {
		$this->app = $app;

		if (!$template || !file_exists($template)) {
			$this->template = self::DEFAULT_TEMPLATE;
		}
		else {
			$this->template = $template;
		}
	}

	/**
	 * Builds the specification and writes to a JSON file.
	 *
	 * @param string $file The location of the output JSON file.
	 * @return void
	 */
	public function write(string $file): void
	{
		$routes = $this->app->getRouteCollector()->getRoutes();

		$openapi = Reader::readFromJsonFile(realpath('openapi.template.json'));

		foreach ($routes as $key => $route) {
			$group = $route->getGroups()[0];

			//var_dump($group->getPattern());

			$reflectionClass = new ReflectionClass($route->getCallable());
			//var_dump($route->getCallable());

			$attr = $reflectionClass->getAttributes(Path::class);
			//var_dump($attr);

			if (sizeof($attr) == 1) {
				$fields = Parser::getFieldsFromCallable($route->getCallable());
				$description = $attr[0]->getArguments()['description'];
				$methods = $route->getMethods();
				$path = $route->getPattern();
				$tags = $group = array_map(fn ($g) => $g->getPattern(), $route->getGroups());

				$descriptor = [
					'summary' => $description,
					'tags' => $tags,
					'requestBody' => [
						'content' => [
							'application/json' => [
								'schema' => [
									'type' => 'object',
									'properties' => []
								]
							]
						]
					],
					'responses' => [
						'200' => [
							'content' => [
								'application/json' => [
									'schema' => [
										'type' => 'object',
										'properties' => []
									]
								]
							]
						]
					]
				];

				foreach ($fields ?? [] as $field) {
					$type = match($field->type) {
						'bool' => 'boolean',
						'int' => 'integer',
						default => 'string',
					};

					if ($field->fieldType === FieldType::Url || $field->fieldType === FieldType::Query) {
						$schema = [
							'name' => $field->name ?: $field->property,
							'in' => $field->fieldType === FieldType::Url ? 'path' : 'query',
							'required' => $field->required,
							'schema' => [
								'type' => $type
							]
						];

						if ($field->default !== null) {
							$schema['default'] = (string)$field->default;
						}

						if ($field->description !== null) {
							$schema['description'] = $field->description;
						}

						$descriptor['parameters'][] = $schema;
					}
					else {
						$schema =  [
							'required' => $field->required,
							'type' => $type
						];

						if ($field->description !== null) {
							$schema['description'] = $field->description;
						}

						if ($field->default !== null) {
							$schema['default'] = $field->default;
						}

						$descriptor['requestBody']['content']['application/json']['schema']['properties'][$field->name ?:
							$field->property] = $schema;
					}
				}

				if (!sizeof($descriptor['requestBody']['content']['application/json']['schema']['properties'])) {
					unset($descriptor['requestBody']);
				}

				// Add response fields
				$responseFields = Parser::getResponseFieldsFromCallable($route->getCallable());
				$attributes = Parser::getResponseDataAttributesFromCallable($route->getCallable());

				if ($attributes) {
					foreach ($attributes['responseCodes'] as $code) {
						$descriptor['responses'][(string)$code]['description'] = HttpResponseCodes::getMessage($code);
					}

					foreach ($responseFields ?? [] as $field) {
						$type = match ($field->type) {
							'int' => 'integer',
							'bool' => 'boolean',
							default => 'string'
						};

						$schema = [
							'type' => $type
						];

						if ($field->type === 'DateTimeImmutable') {
							$schema['format'] = 'date-time';
						}

						if ($field->description !== null) {
							$schema['description'] = $field->description;
						}

						$descriptor['responses']['200']['content']['application/json']['schema']['properties'][$field->property] = $schema;
					}

					if (!sizeof($descriptor['responses']['200']['content']['application/json']['schema']['properties'])) {
						unset($descriptor['responses']['200']['content']);
					}

					if ($attributes['array']) {
						$descriptor['responses']['200']['content']['application/json']['schema'] = [
							'type' => 'array',
							'items' => [
								'type' => 'object',
								'properties' => $descriptor['responses']['200']['content']['application/json']['schema']['properties']
							]
						];
					}
				}

				if (!$openapi->paths->hasPath($path)) {
					$openapi->paths[$path] = new PathItem([]);
				}
				$openapi->paths[$path]->{strtolower($methods[0])} = $descriptor;

				$x = [$fields, $description, $methods, $path, $tags];
			}
		}

		$json = Writer::writeToJson($openapi);

		file_put_contents($file, $json);
	}
}