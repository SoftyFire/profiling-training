<?php

namespace app\models;

class NewsStats
{
    protected $wordsCount = [];

    protected $count;

    function __construct($wordsCount, $newsCount)
    {
        $this->wordsCount = $wordsCount;
        $this->count = $newsCount;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int)$this->count;
    }

    public function getTopWords($count)
    {
        asort($this->wordsCount, SORT_NUMERIC);

        return array_slice(array_reverse($this->wordsCount), 0, $count, true);
    }
}
