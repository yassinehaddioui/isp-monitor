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

class BaseSerializableModel implements JsonSerializable, MongoDB\BSON\Serializable
{
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    protected function toArray(){
        $array = [];
        foreach ($this as $key => $value) {
            $method = '';
            if (method_exists($this, $method = ('get' . ucfirst($key)))
                || method_exists($this, $method = ('is' . ucfirst($key))))
                $array[$key] = $this->$method();
        }
        return $array;
    }

    public function bsonSerialize()
    {
        return $this->jsonSerialize();
    }
}