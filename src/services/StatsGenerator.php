<?php

namespace app\services;

use app\models\News;
use app\models\NewsStats;

/**
 * Class StatsGenerator
 *
 * Generates [[NewsStats]] out of existing news.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class StatsGenerator
{
    /**
     * @return NewsStats
     */
    public function generate(): NewsStats
    {
        return new NewsStats($this->wordsCount(), $this->newsCount());
    }

    /**
     * Counts words stats
     *
     * @return array
     */
    private function wordsCount(): array
    {
        /** @var News $allNews */
        $allNews = News::find()->all();
        $wordsCount = [];

        foreach ($allNews as $news) {
            $this->countWordsInNews($news, $wordsCount);
        }

        return $wordsCount;
    }

    /**
     * @return int news count
     */
    private function newsCount(): int
    {
        return \count(News::find()->all());
    }

    /**
     * @param News $news
     * @param array $wordsCount
     */
    private function countWordsInNews($news, &$wordsCount): void
    {
        $text = preg_replace('/[^a-z0-9 ]/', ' ', mb_strtolower($news->text));
        $words = preg_split('/\s/', $text, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($words as $word) {
            if (!isset($wordsCount[$word])) {
                $wordsCount[$word] = 1;
            } else {
                $wordsCount[$word]++;
            }
        }
    }
}
