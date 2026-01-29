<?php

/** @var yii\web\View $this */
/** @var app\models\Author $model */
/** @var app\requests\AuthorRequest $request */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Добавить автора';
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="author-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($request, 'full_name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

