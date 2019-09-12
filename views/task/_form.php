<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Task;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

$priorities = Task::instance()->getPriorityRuList();
$priorities = ['0' => 'Выберите приоритет'] + $priorities;

$statuses = Task::instance()->getStatusRuList();
$statuses = ['0' => 'Выберите статус'] + $statuses;
?>

<div class="task-form">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'priority')->dropDownList($priorities, ['class' => 'form-control', 'options' => ['0' => ['selected' => true, 'disabled' => true]]]) ?>

        <?= $form->field($model, 'status')->dropDownList($statuses, ['class' => 'form-control', 'options' => ['0' => ['selected' => true, 'disabled' => true]]]) ?>
        
        <?= $form->field($model, 'tags')->textInput(['value' => $model->tagsList])->label($model->getAttributeLabel('tags') . ', через запятую') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
