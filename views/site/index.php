<?php

/* @var $this yii\web\View */

$title = 'Главная';
$this->title = Yii::$app->name . ' | ' . $title;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Приложение "Задачи"</h1>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Пользователи</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span>Активные</span>
                            <span class="pull-right"><?= $total_active_users ?></span>
                        </p>
                        <p>
                            <span>Неактивные</span>
                            <span class="pull-right"><?= $total_inactive_users ?></span>
                        </p>
                        <p>
                            <span>Всего</span>
                            <span class="pull-right"><?= $total_users ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Задачи</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span>В работе</span>
                            <span class="pull-right"><?= $total_inwork_tasks ?></span>
                        </p>
                        <p>
                            <span>Завершено</span>
                            <span class="pull-right"><?= $total_completed_tasks ?></span>
                        </p>
                        <p>
                            <span>Всего</span>
                            <span class="pull-right"><?= $total_tasks ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Задачи</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span>Высокий приоритет</span>
                            <span class="pull-right"><?= $total_high_tasks ?></span>
                        </p>
                        <p>
                            <span>Средний приоритет</span>
                            <span class="pull-right"><?= $total_mid_tasks ?></span>
                        </p>
                        <p>
                            <span>Низкий приоритет</span>
                            <span class="pull-right"><?= $total_low_tasks ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
