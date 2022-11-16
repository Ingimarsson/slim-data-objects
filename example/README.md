# Slim Data Objects Example

Here is a basic example of a Slim app that uses this library.

## Setup

First install the dependencies

	composer install

Then you can start a development server

	cd public/
	php -S localhost:3000

## Generate OpenAPI specification

To generate the OpenAPI specification as a JSON file, run the following command

	./vendor/bin/openapi-builder src/app.php openapi.template.json public/openapi/openapi.json