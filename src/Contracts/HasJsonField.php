<?php

namespace Digitalmanagerguru\LaravelJsonFields\Contracts;

interface HasJsonField
{
    public function hasJsonKey($key): bool;

    public function getJsonKeyValue($key, $default = null);

    public function setJsonKeyValue($key, $value): void;

    public function mergeJsonKeyValue($key, array $value): void;

    public function forgetJsonKey($key): void;

    public function hasJsonField(): bool;

    public function getJsonFieldValue(): array;

    public function setJsonFieldValue(array $value): void;

    public function getJsonFieldName(): string;

    public function isEmptyJsonKeyValue($key): bool;

    public function addLog($value): void;
}
