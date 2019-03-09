<?php

namespace App\Models\Traits;

use ReflectionClass;
use Illuminate\Support\Str;

/**
 * Trait HasParentModel
 * @package App\Models\Traits
 */
trait HasParentModel
{
    /**
     * @return string
     */
    public function getParentClass()
    {
        static $parentClassName;
        
        return $parentClassName ?: $parentClassName = (new ReflectionClass($this))->getParentClass()->getName();
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        if (! isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this->getParentClass()))));
        }

        return $this->table;
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return Str::snake(class_basename($this->getParentClass())).'_'.$this->primaryKey;
    }

    /**
     * @param $related
     * @return string
     */
    public function joiningTable($related)
    {
        $models = [
            Str::snake(class_basename($related)),
            Str::snake(class_basename($this->getParentClass())),
        ];

        sort($models);

        return strtolower(implode('_', $models));
    }
}
