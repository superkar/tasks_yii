<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;


$title = 'Регистрация';
$this->title = Yii::$app->name . ' | ' . $title;
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-signup">
    <h1><?= Html::encode($title) ?></h1>

    <p>Пожалуйста, заполните следующие поля:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput()->label($model->getAttributeLabel('password') . ' (минимум 8 символов)') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
