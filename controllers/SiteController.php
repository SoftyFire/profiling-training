<?php

namespace app\controllers;

use app\models\News;
use app\services\NewsGenerator;
use app\services\StatsGenerator;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionGenerateNews($count = 40)
    {
        /** @var NewsGenerator $newsGenerator */
        $this->newsGenerator->generate($count);

        return $this->render('generation-result', [
            'number' => $count
        ]);
    }

    public function actionView()
    {
        return $this->render('view', [
            'newsDataProvider' => new ActiveDataProvider([
                'query' => News::find()
                    ->with(['tags' => function ($query) {
                        /** @var ActiveQuery $query */
                        $query->with('news');
                    }])
                    // ->with('tags.news') // the same as above
                    ->orderBy('id desc'),
                'pagination' => [
                    'pageSize' => 100,
                ],
            ]),
        ]);
    }

    public function actionStats()
    {
        $stats = $this->statsGenerator->generate();

        return $this->render('stats', [
            'stats' => $stats
        ]);
    }
}
