<?php

/** @var yii\web\View $this */
/** @var app\models\Author[] $authors */

use yii\bootstrap5\Html;

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($authors as $author): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($author->full_name) ?></h5>
                        <p class="card-text">
                            <strong>Книг:</strong> <?= count($author->books) ?>
                        </p>
                        <?= Html::a('Подробнее', ['view', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

