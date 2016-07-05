<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [

                        'name',
                        'phone',
                        'address',
                        [
                            'attribute' => 'total',
                            'value' => number_format($model->total, 0, '', '.'),
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => date('d/m/Y', $model->created_at),
                        ],
                    ],
                ])
                ?>

            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body">

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'columns' => [

                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'images',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return '<img width="50" src="/uploads/thumbs/' . $data['image'] . '">';
                            }
                        ],
                        'name',
                        'quantity',
                        [
                            'attribute' => 'price',
                            'format' => 'raw',
                            'value' => function($data) {
                                return number_format($data['price'], 0, '', '.');
                            }
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>