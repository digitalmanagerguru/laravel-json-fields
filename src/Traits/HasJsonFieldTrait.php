<?php

namespace Digitalmanagerguru\LaravelJsonFields\Traits;

trait HasJsonFieldTrait
{
    public function hasJsonKey($key): bool
    {
        return \Arr::has($this->getJsonFieldValue(), $key);
    }

    public function hasJsonField(): bool
    {
        return empty($this->getJsonFieldValue());
    }

    public function getJsonKeyValue($key, $default = null)
    {
        $value = \Arr::get($this->getJsonFieldValue(), $key);

        return ! filled($value) ? $default : $value;
    }

    public function setJsonKeyValue($key, $value): void
    {
        $json = $this->getJsonFieldValue();

        \Arr::set($json, $key, $value);

        $this->setJsonFieldValue($json);
    }

    public function mergeJsonKeyValue($key, array $value): void
    {
        $targetArray = $this->getJsonKeyValue($key, []);

        $mergedArray = array_replace_recursive($targetArray, $value);

        $this->setJsonKeyValue($key, $mergedArray);
    }

    public function forgetJsonKey($key): void
    {
        $json = $this->getJsonFieldValue();

        $keys = \Arr::wrap($key);

        collect($keys)->each(function ($item) use (&$json) {
            \Arr::forget($json, $item);
        });

        $this->setJsonFieldValue($json);
    }

    public function getJsonFieldValue(): array
    {
        $json = \Arr::get($this->attributes, $this->getJsonFieldName());

        if (is_array($json)) {
            return $json;
        }

        return (empty($json) || $json == 'null') ? [] : json_decode($json, JSON_FORCE_OBJECT);
    }

    public function setJsonFieldValue(array $value): void
    {
        $this->attributes[$this->getJsonFieldName()] = json_encode($value, JSON_FORCE_OBJECT);
    }

    public function getJsonFieldName(): string
    {
        return ! empty($this->jsonField) ? $this->jsonField : 'metadata';
    }

    public function isEmptyJsonKeyValue($key): bool
    {
        return empty($this->getJsonKeyValue($key));
    }

    public function addLog($value): void
    {
        $this->setJsonKeyValue('log.'.now()->toDateTimeString(), $value);
    }
}
