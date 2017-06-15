<?php

namespace app\services;

use app\models\News;
use app\models\NewsTags;
use app\models\Tag;

class NewsGenerator
{
    protected $existingTags;

    /**
     * @param int $number Number of news to be generated
     * @void
     */
    public function generate($number)
    {
        $rows = [];
        for ($i = 0; $i < $number; $i++) {
            $rows[] = $this->createRandomNews();
        }
        News::getDb()->createCommand()->batchInsert(News::tableName(), ['title', 'text'], $rows)->execute();

        $rows = [];
        foreach (News::find()->orderBy('id desc')->limit($number)->all() as $news) {
            $rows = array_merge($rows, $this->generateTagsForNews($news));
        }
        NewsTags::getDb()->createCommand()->batchInsert(NewsTags::tableName(), ['news_id', 'tag_id'], $rows)->execute();
    }

    /**
     * @return array
     */
    protected function createRandomNews()
    {
        return [
            'title' => $this->generateRandomTitle(),
            'text' => $this->generateRandomText(),
        ];
    }

    /**
     * @return Tag
     */
    protected function getRandomTag()
    {
        $availableTags = [
            'hit',
            'politics',
            'culture',
            'technologies',
            'health',
            'music',
            'cinema',
            'climate',
            'science',
            'nature',
            'photography',
            'biology',
        ];

        $i = mt_rand(0, count($availableTags) - 1);

        return $this->ensureTag($availableTags[$i]);
    }

    /**
     * @param string $name
     * @return Tag
     */
    protected function ensureTag($name)
    {
        if (isset($this->getExistingTags()[$name])) {
            return $this->getExistingTags()[$name];
        }

        $tag = new Tag(['name' => $name]);
        $tag->save();

        $this->existingTags[$name] = $tag;

        return $tag;
    }

    /**
     * @param News $news
     * @return array
     */
    protected function generateTagsForNews($news)
    {
        $result = [];
        $count = mt_rand(1, 5);

        for ($i = 0; $i < $count; $i++) {
            $result[] = [
                'news_id' => $news->id,
                'tag_id' => $this->getRandomTag()->id
            ];
        }

        return $result;
    }

    protected function generateRandomTitle()
    {
        return 'Lorem ipsum dolor sir emet';
    }

    protected function generateRandomText()
    {
        return str_repeat('Lorem ipsum dolor sir emet.', mt_rand(7, 23));
    }

    private function getExistingTags()
    {
        if (!isset($this->existingTags)) {
            $this->existingTags = Tag::find()->indexBy('name')->all();
        }

        return $this->existingTags;
    }

}
