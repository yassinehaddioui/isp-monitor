<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 9:42 PM
 */

namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class Reservation extends BaseSerializableModel
{
    /**
     * @var string $_id ;
     */
    protected $_id = '';
    /**
     * @var string $email
     */
    protected $email = '';
    /**
     * @var int $dateCreated
     */
    protected $dateCreated = 0;
    /**
     * @var string $eventId
     */
    protected $eventId = '';
    /**
     * @var string $ipAddress
     */
    protected $ipAddress = '';
    /**
     * @var string $browserSignature
     */
    protected $browserSignature = '';

    /**
     * Reservation constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        if (!empty($params))
            $this->fromArray($params);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $id
     * @return Reservation
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param int $dateCreated
     * @return Reservation
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param string $eventId
     * @return Reservation
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return Reservation
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrowserSignature()
    {
        return $this->browserSignature;
    }

    /**
     * @param string $browserSignature
     * @return Reservation
     */
    public function setBrowserSignature($browserSignature)
    {
        $this->browserSignature = $browserSignature;
        return $this;
    }

    public function validate(){
        $exceptions = [];
        if (!$this->getEmail() || !filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL))
            $exceptions[] = "Email is required.";
        if (!$this->getEventId())
            $exceptions[] = "Event ID is required.";
        if (!empty($exceptions))
            throw new \InvalidArgumentException(implode(", ", $exceptions));
    }
}