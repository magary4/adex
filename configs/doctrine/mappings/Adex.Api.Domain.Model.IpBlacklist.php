<?php

/** @var \Doctrine\Orm\Mapping\ClassMetadata $metadata */
$metadata->setPrimaryTable([
    'name' => 'ip_blacklist'
]);

$metadata->mapField([
    'id' => true,
    'fieldName' => 'ip',
    'columnName' => 'ip',
    'type' => 'bigint',
    'nullable' => false,
    'unique' => true
]);
