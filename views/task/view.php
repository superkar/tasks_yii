<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$title = $model->title;
$this->title = Yii::$app->name . ' | ' . 'Задача: ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uuid',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username
            ],
            'title',
            [
                'attribute' => 'tags',
                'value' => $model->tagsList, 
            ],
            [
                'attribute' => 'priority',
                'value' => $model->priorityRu,
            ],
            [
                'attribute' => 'status',
                'value' => $model->statusRu,
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd/MM/Y в HH:mm'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd/MM/Y в HH:mm'],
            ],
        ],
    ]) ?>

</div>
