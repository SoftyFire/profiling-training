<?php

namespace app\services;

use app\models\Article;
use app\models\ArticlesStats;

/**
 * Class StatsGenerator
 *
 * Generates [[ArticlesStats]] out of existing news.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class StatsGenerator
{
    /**
     * @return ArticlesStats
     */
    public function generate(): ArticlesStats
    {
        return new ArticlesStats($this->wordsCount(), $this->newsCount());
    }

    /**
     * Counts words stats
     *
     * @return array
     */
    private function wordsCount(): array
    {
        /** @var Article $allNews */
        $allNews = Article::find()->all();
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
        return \count(Article::find()->all());
    }

    /**
     * @param Article $news
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
