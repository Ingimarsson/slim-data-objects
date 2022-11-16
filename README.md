# Slim Data Objects

Slim Data Objects is a library for [Slim](https://github.com/slimphp/Slim) that allows you to specify the format of your requests and responses as data classes. You simply add annotations on your route callables, specifying the data classes for that path. The library can then

 - Validate incoming requests according to the properties of a specified request data class (url params, query params and body fields)
 - Automatically generate OpenAPI documentation for the application
 - Allow you to access your request data as a typed object rather than an associative array.

This library uses [rakit/validation](https://github.com/rakit/validation) for validation and [cebe/php-openapi](https://github.com/cebe/php-openapi) for building OpenAPI specifications.

## Installation

The library can be installed with composer

```php
composer require ingimarsson/slim-data-objects
```

## Basic usage

Let's say we have a simple Slim application with a single POST route definition

```php
$app = AppFactory::create();

$app->post('/{id}', PostAction::class);
```

We now create a data class that specifies the format of the request for this route, note that the fields can come from the URL, query parameters, and the parsed body.

```php
use Ingimarsson\SlimDataObjects\Attribute\Field;
use Ingimarsson\SlimDataObjects\Enum\FieldType;
use Ingimarsson\SlimDataObjects\RequestData;

class PostRequestData extends RequestData {
	public function __construct(
		#[Field(type: FieldType::Url, description: "Important value")]
		public readonly int $id,

		#[Field(type: FieldType::Query, description: "Less important value", required: false, default: "test")]
		public readonly string $email,

		#[Field(type: FieldType::Body, description: "Very important value")]
		public readonly string $name,
	) {}
}
```

In our action class, we can now add an attribute to specify this data class

```php
use Ingimarsson\SlimDataObjects\Attribute\Path;
use Ingimarsson\SlimDataObjects\Attribute\RequestDataClass;

#[Path(description: "A simple POST endpoint")]
#[RequestDataClass(class: PostRequestData::class)]
class PostAction {
	public function __invoke(Request $request, Response $response, array $args): Response {
		$data = PostRequestData::fromRequest($request);

		// Access input fields from object
		var_dump($data->id, $data->email, $data->name);

		return $response;
	}
}
```

Now we can access all the input fields from our `PostRequestData` instance. Finally, we need to add the validation middleware.

```php
use Ingimarsson\SlimDataObjects\Middleware\ValidatorMiddleware;

$app->addMiddleware(new ValidatorMiddleware());
```

See the `example/` directory for a more detailed example.

## OpenAPI specifications

Note that in our example above, we also added the `Path` attribute on our action class. That will include this endpoint OpenAPI in our generated specification. To generate the specification, run the following command

	./vendor/bin/openapi-builder src/app.php openapi.template.json public/openapi/openapi.json

The script `app.php` must return an instance of your `\Slim\App` instance with all routes registered. The second argument is an OpenAPI JSON file that is used as a template to build upon. The last argument is the output destination.

You can see an example of the output specification in `examples/public/openapi/openapi.json`

## License

See [LICENSE.md](./LICENSE.md)