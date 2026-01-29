<?php

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\requests\BookRequest $request */
/** @var app\models\Author[] $authors */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Редактировать книгу: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($request, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($request, 'year')->textInput(['type' => 'number']) ?>

        <?= $form->field($request, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($request, 'isbn')->textInput(['maxlength' => true]) ?>

        <?php if ($model->cover_photo): ?>
            <div class="mb-3">
                <label class="form-label">Текущее фото:</label><br>
                <img src="<?= Html::encode($model->cover_photo) ?>" alt="Обложка" class="img-thumbnail" style="max-width: 200px;">
            </div>
        <?php endif; ?>

        <?= $form->field($request, 'cover_photo_file')->fileInput(['accept' => 'image/*']) ?>
        <p class="text-muted small">Разрешены форматы: JPG, PNG, GIF, WEBP. Максимальный размер: 5MB. Оставьте пустым, чтобы сохранить текущее фото.</p>

        <?= $form->field($request, 'authors')->checkboxList(
            ArrayHelper::map($authors, 'id', 'full_name')
        )->label('Авторы') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

