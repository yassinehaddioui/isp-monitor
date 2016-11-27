<?php

namespace IspMonitor\Models;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Psr\Log\InvalidArgumentException;
use IspMonitor\Models\Base\BaseSerializableModel;

class StreamSpeed extends BaseSerializableModel
{
    /**
     * @var string
     */
    protected $unitSize = '';
    /**
     * @var string
     */
    protected $unitTime = '';


    /**
     * StreamSpeed constructor.
     * @param string $unitSize
     * @param string $unitTime
     * @throws InvalidArgumentException
     */
    public function __construct($unitSize = 'KB', $unitTime = 's')
    {
        try {
            Assertion::notBlank($unitSize);
            Assertion::notBlank($unitTime);
            Assertion::string($unitSize);
            Assertion::string($unitTime);
        } catch (AssertionFailedException $e) {
            throw new InvalidArgumentException();
        }
        $this->unitSize = $unitSize;
        $this->unitTime = $unitTime;
    }

    /**
     * @return string
     */
    public function getUnitSize()
    {
        return $this->unitSize;
    }


    /**
     * @return string
     */
    public function getUnitTime()
    {
        return $this->unitTime;
    }

    /**
     * @return string
     */

    public function __toString()
    {
        return $this->unitSize . '/' . $this->unitTime;
    }


}