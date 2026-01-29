<?php

/** @var yii\web\View $this */
/** @var app\models\Author[] $authors */
/** @var int $year */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'ТОП 10 авторов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['/report/top-authors']]); ?>
            <?= Html::textInput('year', $year, ['class' => 'form-control', 'placeholder' => 'Год', 'type' => 'number']) ?>
            <?= Html::submitButton('Показать', ['class' => 'btn btn-primary mt-2']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <h2>За <?= Html::encode($year) ?> год</h2>

    <?php if (empty($authors)): ?>
        <p>Нет данных за выбранный год.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Место</th>
                    <th>Автор</th>
                    <th>Количество книг</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $index => $author): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($author->full_name) ?></td>
                        <td><?= $author->getBooksCountByYear($year) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

