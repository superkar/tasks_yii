<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = 'Задачи';
$this->title = Yii::$app->name . ' | ' . $title;
$this->params['breadcrumbs'][] = $title;
?>
<div class="task-index">

    <h1><?= Html::encode($title) ?></h1>

    <p>
        <?= Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false, 'id' => 'task-index-pjax']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'tags',
                'format' => 'ntext',
                'content' => function ($data) {
                    return $data->tagsList;
                }
            ],
            [
                'attribute' => 'priority',
                'content' => function ($data) {
                    return $data->priorityRu;
                }
            ],
            [
                'attribute' => 'status',
                'content' => function ($data) {
                    return $data->statusRu;
                }
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd/MM/Y, HH:mm'],
            ],
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
