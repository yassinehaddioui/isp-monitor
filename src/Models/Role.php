<?php


namespace IspMonitor\Models;

use IspMonitor\Models\Base\BaseSerializableModel;

class Role extends BaseSerializableModel
{
    /** @var  string $name */
    protected $name;
    /** @var  string $domain */
    protected $domain;

    /**
     * Role constructor.
     * @param string $name
     * @param string $domain
     */
    public function __construct($name, $domain)
    {
        $this->name = $name;
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

}