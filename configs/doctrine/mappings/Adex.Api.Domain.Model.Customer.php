<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

/** @var \Doctrine\Orm\Mapping\ClassMetadata $metadata */
$metadata->setPrimaryTable([
    'name' => 'customer',
]);

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);

$metadata->mapField([
    'id' => true,
    'fieldName' => 'id',
    'columnName' => 'id',
    'type' => 'integer',
    'nullable' => false,
    'unique' => true,
]);

$metadata->mapField([
    'fieldName' => 'name',
    'columnName' => 'name',
    'type' => 'string',
    'nullable' => false
]);

$metadata->mapField([
    'fieldName' => 'active',
    'columnName' => 'active',
    'type' => 'boolean',
    'nullable' => false,
    'default' => 1
]);