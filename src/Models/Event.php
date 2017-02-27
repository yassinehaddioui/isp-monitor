<?php


namespace IspMonitor\Models;


class Event extends Base\BaseSerializableModel
{
    /**
     * @var string $_id
     */
    protected $_id;
    /**
     * @var string $name
     */
    protected $name;
    /**
     * @var string $description
     */
    protected $description;
    /**
     * @var int $dateStart
     */
    protected $dateStart;
    /**
     * @var int $dateEnd
     */
    protected $dateEnd;
    /**
     * @var null|int $registrationDateStart
     */
    protected $registrationDateStart;
    /**
     * @var null|int $registrationDateEnd
     */
    protected $registrationDateEnd;
    /**
     * @var int $maximumCapacity
     */
    protected $maximumCapacity = 0;

    /**
     * @var int $reservationCount
     */
    protected $reservationCount = 0;
    /**
     * @var bool $exposeReservations
     */
    protected $exposeReservations = false;
    /**
     * @var int $dateCreated
     */
    protected $dateCreated;
    /**
     * @var int $lastUpdate
     */
    protected $lastUpdate;

    /**
     * @var string $creatorId
     */
    protected $creatorId;

    /**
     * Event constructor.
     * @param array $dataArray
     */
    public function __construct($dataArray = [])
    {
        if (!empty($dataArray))
            $this->fromArray($dataArray);
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
     * @return Event
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param int $dateStart
     * @return Event
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param int $dateEnd
     * @return Event
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRegistrationDateStart()
    {
        return $this->registrationDateStart;
    }

    /**
     * @param int|null $registrationDateStart
     * @return Event
     */
    public function setRegistrationDateStart($registrationDateStart)
    {
        $this->registrationDateStart = $registrationDateStart;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRegistrationDateEnd()
    {
        return $this->registrationDateEnd;
    }

    /**
     * @param int|null $registrationDateEnd
     * @return Event
     */
    public function setRegistrationDateEnd($registrationDateEnd)
    {
        $this->registrationDateEnd = $registrationDateEnd;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumCapacity()
    {
        return $this->maximumCapacity;
    }

    /**
     * @param int $maximumCapacity
     * @return Event
     */
    public function setMaximumCapacity($maximumCapacity)
    {
        $this->maximumCapacity = $maximumCapacity;
        return $this;
    }

    /**
     * @return int
     */
    public function getReservationCount()
    {
        return $this->reservationCount;
    }

    /**
     * @param int $reservationCount
     * @return Event
     */
    public function setReservationCount($reservationCount)
    {
        $this->reservationCount = $reservationCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @param string $creatorId
     * @return Event
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;
        return $this;
    }


    /**
     * @return bool
     */
    public function isExposeReservations()
    {
        return $this->exposeReservations;
    }

    /**
     * @param bool $exposeReservations
     * @return Event
     */
    public function setExposeReservations($exposeReservations)
    {
        $this->exposeReservations = $exposeReservations;
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
     * @return Event
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param int $lastUpdate
     * @return Event
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    /**
     *
     */
    public function validate(){
        $exceptions = [];
        if (!$this->getName())
            $exceptions[] = "Name is required.";
        if (!$this->getDateStart() || !$this->getDateEnd())
            $exceptions[] = "Date start/end required.";
        if ($this->getDateEnd() < time())
            $exceptions[] = "Date end cannot be in the past.";

        if (!empty($exceptions))
            throw new \InvalidArgumentException(implode(", ", $exceptions));
    }
}