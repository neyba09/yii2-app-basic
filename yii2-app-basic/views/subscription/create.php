<?php

/** @var yii\web\View $this */
/** @var app\models\Subscription $model */
/** @var app\requests\SubscriptionRequest $request */
/** @var app\models\Author[] $authors */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Подписка на автора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Укажите номер телефона и выберите автора, на новые книги которого вы хотите подписаться.</p>

    <div class="subscription-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($request, 'author_id')->dropDownList(
            \yii\helpers\ArrayHelper::map($authors, 'id', 'full_name'),
            ['prompt' => 'Выберите автора']
        ) ?>

        <?= $form->field($request, 'guest_phone')->textInput(['maxlength' => true, 'placeholder' => '+79001234567']) ?>

        <div class="form-group">
            <?= Html::submitButton('Подписаться', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
