<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = !empty($category) ? $category->name : 'Apps Games';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index">
    <div class="body-content">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "{items}\n{pager}",
            'itemView' => '_item',
        ]);
        ?>
    </div>
</div>
