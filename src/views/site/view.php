<?php

/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $newsDataProvider
 */


$this->title = 'View news';
?>

<div class="site-view-news">
    <div class="body-content">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $newsDataProvider,
            'itemView' => '_news-item'
        ]) ?>
    </div>
</div>
