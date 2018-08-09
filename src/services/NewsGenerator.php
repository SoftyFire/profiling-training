<?php

namespace app\services;

use app\models\News;
use app\models\Tag;

/**
 * Class NewsGenerator
 *
 * Generates random news for testing purposes.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class NewsGenerator
{
    /**
     * @var \joshtronic\LoremIpsum
     */
    private $ipsum;

    /**
     * NewsGenerator constructor.
     *
     * @param \joshtronic\LoremIpsum $ipsum
     */
    function __construct(\joshtronic\LoremIpsum $ipsum)
    {
        $this->ipsum = $ipsum;
    }

    /**
     * @param int $number Number of news to be generated
     * @void
     */
    public function generate($number)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->createRandomNews();
        }
    }

    /**
     * @return News
     */
    private function createRandomNews()
    {
        $news = new News([
            'title' => $this->generateRandomTitle(),
            'text' => $this->generateRandomText(),
        ]);
        $news->save();
        $this->generateTagsForNews($news);

        return $news;
    }

    /**
     * @return Tag
     */
    private function getRandomTag()
    {
        $tags = [
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

        $i = mt_rand(0, count($tags) - 1);

        return $this->ensureTag($tags[$i]);
    }

    /**
     * @param string $name
     * @return Tag
     */
    private function ensureTag($name)
    {
        if ($tag = Tag::find()->where(['name' => $name])->one()) {
            return $tag;
        }

        $tag = new Tag(['name' => $name]);
        $tag->save();

        return $tag;
    }

    /**
     * @param News $news
     * @void
     */
    private function generateTagsForNews($news)
    {
        $count = mt_rand(1, 5);

        for ($i = 0; $i < $count; $i++) {
            $news->link('tags', $this->getRandomTag());
        }
    }

    /**
     * @return string
     */
    private function generateRandomTitle()
    {
        return $this->ipsum->words(8);
    }

    /**
     * @return string
     */
    private function generateRandomText()
    {
        return $this->ipsum->paragraphs(2);
    }
}
