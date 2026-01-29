<?php

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\requests\BookRequest $request */
/** @var app\models\Author[] $authors */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-form">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
        ]); ?>

        <?= $form->field($request, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($request, 'year')->textInput(['type' => 'number']) ?>

        <?= $form->field($request, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($request, 'isbn')->textInput(['maxlength' => true]) ?>

        <?= $form->field($request, 'cover_photo_file')->fileInput(['accept' => 'image/*']) ?>
        <p class="text-muted small">Разрешены форматы: JPG, PNG, GIF, WEBP. Максимальный размер: 5MB</p>

        <?= $form->field($request, 'authors')->checkboxList(
            \yii\helpers\ArrayHelper::map($authors, 'id', 'full_name')
        )->label('Авторы') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

