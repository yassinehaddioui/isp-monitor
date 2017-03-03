<?php


namespace IspMonitor\Models;




class EventFilter extends BaseFilter
{
    const PRESET_UPCOMING = 'upcoming';
    const PRESET_ONGOING = 'ongoing';
    const PRESET_OPEN = 'open';

    const DEFAULT_PRESET = self::PRESET_UPCOMING;

    /** @var string $preset */
    protected $preset;

    /**
     * BaseFilter constructor.
     * @param $limit
     * @param $sortBy
     * @param $sortOrder
     * @param $preset
     */
    public function __construct($limit = self::DEFAULT_LIMIT,
                                $sortBy = self::DEFAULT_SORT_BY,
                                $sortOrder = self::DEFAULT_SORT_ORDER,
                                $preset = '')
    {
        parent::__construct($limit, $sortBy, $sortOrder);
        $this->preset = $preset;
    }

    /**
     * @return string
     */
    public function getPreset()
    {
        return $this->preset;
    }

    /**
     * @param string $preset
     * @return EventFilter
     */
    public function setPreset($preset)
    {
        $this->preset = $preset;
        return $this;
    }





}