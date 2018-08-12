<?php

namespace app\tests;

use app\models\Article;
use app\services\ArticlesGenerator;
use joshtronic\LoremIpsum;
use PHPUnit\Framework\TestCase;

/**
 * Class ArticlesGeneratorTest
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class ArticlesGeneratorTest extends TestCase
{
    /**
     * @var ArticlesGenerator
     */
    protected $generator;

    public function setUp()
    {
        $this->generator = new ArticlesGenerator(new LoremIpsum());
    }

    public function testGeneratesArticles()
    {
        // TODO: measure and assert performance of articles generation
        $articles = $this->generator->generate(100);

        $this->assertContainsOnlyInstancesOf(Article::class, $articles);

        $article = $articles[0];
        $this->assertNotEmpty($article->title);
        $this->assertNotEmpty($article->text);
        $this->assertNotEmpty($article->id);
        $this->assertNotEmpty($article->tags);
    }
}
