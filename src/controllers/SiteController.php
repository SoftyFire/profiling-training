<?php

namespace app\controllers;

use app\models\News;
use app\services\NewsGenerator;
use app\services\StatsGenerator;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @var NewsGenerator
     */
    private $newsGenerator;
    /**
     * @var StatsGenerator
     */
    private $statsGenerator;

    public function __construct(
        $id, Module $module,
        NewsGenerator $newsGenerator, StatsGenerator $statsGenerator,
        array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->newsGenerator = $newsGenerator;
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
    public function actionGenerateNews($count = 40): string
    {
        /** @var NewsGenerator $newsGenerator */
        $this->newsGenerator->generate($count);

        return $this->render('generation-result', [
            'number' => $count
        ]);
    }

    public function actionView(): string
    {
        return $this->render('view', [
            'newsDataProvider' => new ActiveDataProvider([
                'query' => News::find()->orderBy('id desc'),
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
