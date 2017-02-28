<?php


namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class User extends BaseSerializableModel
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /** @var  string $_id */
    protected $_id;
    /** @var  string $email */
    protected $email;
    /** @var  string $name */
    protected $name;
    /** @var  string $password */
    protected $password;
    /** @var  int $dateCreated */
    protected $dateCreated;
    /** @var  Role[] */
    protected $roles;
    /** @var int $status */
    protected $status;
    /** @var  int $lastUpdate */
    protected $lastUpdate;

    /**
     * User constructor.
     * @param string $id
     * @param string $email
     * @param string $name
     * @param string $password
     * @param Role[] $roles
     * @param int $status
     * @param int $dateCreated
     * @param int $lastUpdate
     */
    public function __construct($id,
                                $email,
                                $name,
                                $password,
                                array $roles = [],
                                $status = self::STATUS_ENABLED,
                                $dateCreated = null,
                                $lastUpdate = null
)
    {
        $this->_id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->roles = $roles;
        $this->status = $status;
        $this->dateCreated = $dateCreated ?: time();
        $this->lastUpdate = $lastUpdate ?: time();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param int $dateCreated
     * @return User
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @param Role[] $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param int $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param int $lastUpdate
     * @return User
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }
}