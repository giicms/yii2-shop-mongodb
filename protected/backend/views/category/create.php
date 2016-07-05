<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">

            <!-- /.box-header -->
            <div class="box-body">
                <?= \common\widgets\Alert::widget() ?>
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>

            </div>
        </div>
    </div>
</div>
