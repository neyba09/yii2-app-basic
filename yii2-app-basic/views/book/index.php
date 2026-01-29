<?php

/** @var yii\web\View $this */
/** @var app\models\Book[] $books */

use yii\bootstrap5\Html;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($books as $book): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if ($book->cover_photo): ?>
                        <img src="<?= Html::encode($book->cover_photo) ?>" class="card-img-top" alt="<?= Html::encode($book->title) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($book->title) ?></h5>
                        <p class="card-text">
                            <strong>Год:</strong> <?= Html::encode($book->year) ?><br>
                            <strong>ISBN:</strong> <?= Html::encode($book->isbn) ?><br>
                            <strong>Авторы:</strong>
                            <?php
                            $authorNames = [];
                            foreach ($book->authors as $author) {
                                $authorNames[] = Html::encode($author->full_name);
                            }
                            echo implode(', ', $authorNames);
                            ?>
                        </p>
                        <?= Html::a('Подробнее', ['view', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

