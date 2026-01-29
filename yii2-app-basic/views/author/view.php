<?php

/** @var yii\web\View $this */
/** @var app\models\Author $model */

use yii\bootstrap5\Html;

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <tr>
                    <th>ФИО</th>
                    <td><?= Html::encode($model->full_name) ?></td>
                </tr>
                <tr>
                    <th>Книги</th>
                    <td>
                        <ul>
                            <?php foreach ($model->books as $book): ?>
                                <li><?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

