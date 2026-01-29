<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список подписок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'author_id',
                'label' => 'Автор',
                'value' => function($model) {
                    return $model->author ? $model->author->full_name : '-';
                }
            ],
            'guest_phone',
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => ['datetime', 'php:d.m.Y H:i'],
            ],
        ],
    ]); ?>
</div>
