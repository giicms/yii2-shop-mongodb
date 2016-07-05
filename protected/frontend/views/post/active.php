<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\web\Session;
use yii\widgets\ListView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <?= $model->title ?>
    </div>
</section>
