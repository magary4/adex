<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

/** @var \Doctrine\Orm\Mapping\ClassMetadata $metadata */
$metadata->setPrimaryTable([
    'name' => 'hourly_stats',
    'uniqueConstraints' => ["unique_customer_time"=>["columns"=>["customer_id","time"]]]
]);

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);

$metadata->mapField([
    'id' => true,
    'fieldName' => 'id',
    'columnName' => 'id',
    'type' => 'integer',
    'nullable' => false,
    'unique' => true
]);

$metadata->mapField([
    'fieldName' => 'customerId',
    'columnName' => 'customer_id',
    'type' => 'integer',
    'nullable' => false
]);


$metadata->mapField([
    'fieldName' => 'time',
    'columnName' => 'time',
    'type' => 'datetime',
    'nullable' => false
]);

$metadata->mapField([
    'fieldName' => 'requestCount',
    'columnName' => 'request_count',
    'type' => 'bigint',
    'nullable' => false,
    'default' => 0
]);

$metadata->mapField([
    'fieldName' => 'invalidCount',
    'columnName' => 'invalid_count',
    'type' => 'bigint',
    'nullable' => false,
    'default' => 0
]);