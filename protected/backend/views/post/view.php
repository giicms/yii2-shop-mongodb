<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'iamges',
                            'format' => 'html',
                            'value' => '<img class="img-rounded" src="/uploads/thumbs/' . $model->images[0] . '">',
                        ],
                        'title',
                        'slug',
                        'content:html',
                        [
                            'attribute' => 'category_id',
                            'value' => $model->category->title,
                        ],
                        'publish',
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
</div>