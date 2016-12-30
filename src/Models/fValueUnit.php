<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 6:03 PM
 */

namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class fValueUnit extends BaseSerializableModel
{

    /** @var  float $value */
    protected $value;
    /** @var  string $unit */
    protected $unit;


    /**
     * UnitFloatValue constructor.
     * @param float $value
     * @param string $unit
     * @param string $string
     */
    public function __construct($value = null, $unit = null, $string = '')
    {
        if (!empty($value))
            $this->value = $value;
        if (!empty($unit))
            $this->unit = $unit;
        if (!empty($string))
            $this->setFromString($string);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return fValueUnit
     */
    public function setValue($value)
    {
        $this->value = (float) $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     * @return fValueUnit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }



    public function setFromString($string)
    {
        $array = explode(' ', $string);
        if (count($array) != 2)
            throw new \InvalidArgumentException('Invalid string to initialize UnitFloatValue conversion.');
        $this->setValue($array[0])->setUnit($array[1]);
    }
}