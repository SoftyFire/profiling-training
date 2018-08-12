<?php

namespace app\controllers;

use app\models\Article;
use app\services\ArticlesGenerator;
use app\services\StatsGenerator;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @var ArticlesGenerator
     */
    private $articlesGenerator;
    /**
     * @var StatsGenerator
     */
    private $statsGenerator;

    public function __construct(
        $id, Module $module,
        ArticlesGenerator $newsGenerator, StatsGenerator $statsGenerator,
        array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->articlesGenerator = $newsGenerator;
        $this->statsGenerator = $statsGenerator;
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @param int $count number of news to be generated
     * @return string
     */
    public function actionGenerateArticles($count = 40): string
    {
        $this->articlesGenerator->generate($count);

        return $this->render('generation-result', [
            'number' => $count
        ]);
    }

    public function actionView(): string
    {
        return $this->render('view', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Article::find()->orderBy('id desc'),
                'pagination' => [
                    'pageSize' => 100,
                ],
            ]),
        ]);
    }

    public function actionStats(): string
    {
        $stats = $this->statsGenerator->generate();

        return $this->render('stats', [
            'stats' => $stats
        ]);
    }
}
