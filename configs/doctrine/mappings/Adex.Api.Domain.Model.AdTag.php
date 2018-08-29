<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

/** @var \Doctrine\Orm\Mapping\ClassMetadata $metadata */
$metadata->setPrimaryTable([
    'name' => 'ad_tag'
]);

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);

$metadata->mapField([
    'id' => true,
    'fieldName' => 'id',
    'columnName' => 'id',
    'type' => 'integer',
    'nullable' => false,
    'unique' => true,
    'primary' => true
]);

$metadata->mapField([
    'fieldName' => 'customerId',
    'columnName' => 'customer_id',
    'type' => 'integer',
    'nullable' => false
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