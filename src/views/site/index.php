<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Yii Application Profiling Master-Class';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <ol>
                <li><?= Html::a('Generate news', ['site/generate-news']) ?></li>
                <li><?= Html::a('View news', ['site/view']) ?></li>
                <li><?= Html::a('View stats', ['site/stats']) ?></li>
            </ol>
        </div>
    </div>
</div>
