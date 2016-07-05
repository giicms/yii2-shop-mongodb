<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'iamges',
                'format' =>'html',
                'value' => '<img class="img-rounded" src="/products/thumbs/'.$model->images[0].'">',
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
