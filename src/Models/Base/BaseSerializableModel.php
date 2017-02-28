<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/26/16
 * Time: 11:38 PM
 */

namespace IspMonitor\Models\Base;

use JsonSerializable;
use MongoDB;

abstract class BaseSerializableModel implements JsonSerializable, MongoDB\BSON\Serializable
{

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this as $key => $value) {
            if (method_exists($this, $method = ('get' . ucfirst(ltrim($key, '_'))))
                || method_exists($this, $method = ('is' . ucfirst(ltrim($key, '_'))))
            )
                $array[$key] = $this->$method();
        }
        return $array;
    }

    public function bsonSerialize()
    {
        return $this->jsonSerialize();
    }

    /**
     * Sets fields based on array keys.
     * Use only for flat structures, nested objects will need special treatment.
     * @param array $data
     */
    protected function fromArray($data){
        foreach($data as $key => $value) {
            if (property_exists($this, $key))
                $this->$key = $value;
        }
    }
}