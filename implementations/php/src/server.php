<?php

declare(strict_types=1);

namespace GraphQL\Compatibility;

require_once __DIR__ . '/../vendor/autoload.php';

use Apollo\Federation\Enum\DirectiveEnum;
use Apollo\Federation\SchemaBuilder;

use GraphQL\Compatibility\Data\DataSource;
use GraphQL\Compatibility\Type\QueryType;
use GraphQL\Server\StandardServer;

// turn off deprecation notices
error_reporting(E_ALL ^ E_DEPRECATED);

try {
    DataSource::init();

    $schema = (new SchemaBuilder())->build(
        [
            'query' => new QueryType(),
        ],
        [
            'directives' => DirectiveEnum::getAll(),
        ],
    );

    $server = new StandardServer([
        'schema' => $schema,
    ]);

    $server->handleRequest();
} catch (\Throwable $error) {
    StandardServer::send500Error($error);
}
