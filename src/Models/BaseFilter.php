<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 3/2/17
 * Time: 3:00 PM
 */

namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class BaseFilter extends BaseSerializableModel
{
    const DEFAULT_LIMIT = 1000;
    const DEFAULT_SORT_BY = '_id';
    const DEFAULT_SORT_ORDER = 'DESC';

    protected $limit;
    protected $sortBy;
    protected $sortOrder;

    /**
     * BaseFilter constructor.
     * @param $limit
     * @param $sortBy
     * @param $sortOrder
     */
    public function __construct($limit = self::DEFAULT_LIMIT,
                                $sortBy = self::DEFAULT_SORT_BY,
                                $sortOrder = self::DEFAULT_SORT_ORDER)
    {
        $this->limit = $limit;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     * @return BaseFilter
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param mixed $sortBy
     * @return BaseFilter
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param mixed $sortOrder
     * @return BaseFilter
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }


}