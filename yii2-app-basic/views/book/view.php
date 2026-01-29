<?php

/** @var yii\web\View $this */
/** @var app\models\Book $model */

use yii\bootstrap5\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped">
                <tr>
                    <th>Название</th>
                    <td><?= Html::encode($model->title) ?></td>
                </tr>
                <tr>
                    <th>Год выпуска</th>
                    <td><?= Html::encode($model->year) ?></td>
                </tr>
                <tr>
                    <th>ISBN</th>
                    <td><?= Html::encode($model->isbn) ?></td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td><?= Html::encode($model->description) ?></td>
                </tr>
                <tr>
                    <th>Авторы</th>
                    <td>
                        <?php
                        $authorNames = [];
                        foreach ($model->authors as $author) {
                            $authorNames[] = Html::encode($author->full_name);
                        }
                        echo implode(', ', $authorNames);
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php if ($model->cover_photo): ?>
            <div class="col-md-4">
                <img src="<?= Html::encode($model->cover_photo) ?>" class="img-fluid" alt="<?= Html::encode($model->title) ?>">
            </div>
        <?php endif; ?>
    </div>
</div>

