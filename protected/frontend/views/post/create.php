<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use frontend\components\widgets\CategoryWidget;
use frontend\components\widgets\ManagerWidget;

$this->title = 'Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page">
    <div class="container">
        <div class="col-sm-2">
            <?= ManagerWidget::widget() ?>
        </div>
        <div class="col-sm-10">
            <h2><?= Html::encode($this->title) ?></h2>
            <?php
            if ($step == 1) {
                ?>
                <?= CategoryWidget::widget() ?>

                <?php
            } else {
                echo $this->render('_form', [
                    'model' => $model,
                ]);
            }
            ?>
        </div>
    </div>
</section>